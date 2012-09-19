<?php
/**
 * Asides
 *
 * Copyright 2011 by Romain Tripault // Melting Media <romain@melting-media.com>
 *
 * Asides is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Asides is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Asides; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package asides
 */
/**
 * The base class for Asides.
 *
 * @package asides
 */
class Asides {
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('asides.core_path',$config,$this->modx->getOption('core_path').'components/asides/');
        $assetsUrl = $this->modx->getOption('asides.assets_url',$config,$this->modx->getOption('assets_url').'components/asides/');
        $connectorUrl = $assetsUrl.'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
            'imagesUrl' => $assetsUrl.'images/',

            'connector_url' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'chunksPath' => $corePath.'elements/chunks/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath.'elements/snippets/',
            'processorsPath' => $corePath.'processors/',

            'templates_path' => $corePath . 'templates/',
        ),$config);

        $this->modx->addPackage('asides',$this->config['modelPath']);
        $this->modx->lexicon->load('asides:default');
    }

    /**
     * Returns a string of resources using a given aside
     *
     * @access public
     * @param array $aside The aside (chunk) object
     */
    public function inResource($aside) {
        // grab the TV
        $asideTV = $this->modx->getObject('modTemplateVar', array('name' => 'aside'));
        $asideTVid = '';
        if ($asideTV) {
            $asideTVid = $asideTV->get('id');
        } else {
            //@TODO: what if it's been renamed ?
        }

        // target the modTemplates with this TV
        $asideTpls = $this->modx->getCollection('modTemplateVarTemplate', array('tmplvarid' => $asideTVid));
        $activeTpls = array();
        foreach ($asideTpls as $tpl) {
            array_push($activeTpls, $tpl->get('templateid'));
        }

        // get the modResources using those tpls
        $res = array();
        foreach ($activeTpls as $activeTpl) {
            $resTargets = $this->modx->getCollection('modResource', array('template' => $activeTpl));
            foreach ($resTargets as $resTarget) {
                array_push($res, $resTarget->get('id'));
            }
        }

        // get the value of the aside TV in those resources
        $matches = array();
        foreach ($res as $resId) {
            $resource = $this->modx->getObject('modResource', $resId);
            $tvValue = $resource->getTVValue('aside');
            $values = explode('||', $tvValue);
            // check if the chunk name is in
            if(in_array($aside->get('name'), $values)) {
                array_push($matches, $resource->get('id'));
            }
        }

        $o = '';
        if ($matches) {
            foreach ($matches as $match) {
                $o .= $match.',';
            }
        }

        return trim($o, ',');
    }

    /**
     * Removes an aside from any existing resource using it
     *
     * @acces public
     * @param string $aside the aside (chunk) name
     * @param string $ids a list of comma separated ids using this aside
     */
    public function cleanAside($aside, $ids) {
        $resIds = explode(',', $ids);
        $tv = $this->modx->getObject('modTemplateVar',array('name' => 'aside'));
        //@TODO: what if the tv has been renamed ?
        foreach ($resIds as $resourceId) {
            $tvValue = $this->modx->getObject('modTemplateVarResource', array('tmplvarid' => $tv->get('id'), 'contentid' => $resourceId));
            $value = str_replace($aside, '', $tvValue->get('value'));
            $value = str_replace('||||', '||', $value);
            $value = trim($value, '||');
            $tv->setValue($resourceId, $value);
            $tv->save();
        }
    }

    /**
     * Initialize a RichText Editor, if set
     *
     * @return void
     */
    public function loadRichTextEditor() {
        // register JS scripts
        $rte = $this->modx->getOption('which_editor');
        // Set which RTE if not core
        //if ($this->modx->context->getOption('use_editor', false, $this->modx->_userConfig) && !empty($rte)) {
        if (!empty($rte)) {
            // invoke OnRichTextEditorRegister event
            $this->modx->invokeEvent('OnRichTextEditorRegister');
            $this->modx->rteFields = array('ta');

            // invoke OnRichTextEditorInit event
            $onRichTextEditorInit = $this->modx->invokeEvent('OnRichTextEditorInit', array(
                'editor' => $rte,
                'elements' => $this->modx->rteFields,
            ));
            if (is_array($onRichTextEditorInit)) {
                implode('', $onRichTextEditorInit);
            }
        }
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name, array $properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->modx->getObject('modChunk', array('name' => $name), true);
            if (empty($chunk)) {
                $chunk = $this->_getTplChunk($name, $this->config['chunkSuffix']);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl by default.
     * @param string $suffix The suffix to add to the chunk filename.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name, $suffix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).$suffix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name', $name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}