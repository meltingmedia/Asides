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
 * Remove an aside chunk.
 *
 * @package asides
 * @subpackage processors
 */

if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('asides.aside_err_ns'));
$aside = $modx->getObject('modChunk',$scriptProperties['id']);
if (!$aside) return $modx->error->failure($modx->lexicon('asides.aside_err_nf'));

// grab the TV
$asideTV = $modx->getObject('modTemplateVar',array('name' => 'aside'));
$asideTVid = $asideTV->get('id');

// target the modTemplates with this TV
$asideTpls = $modx->getCollection('modTemplateVarTemplate',array('tmplvarid' => $asideTVid));
$activeTpls = array();
foreach ($asideTpls as $tpl) {
    array_push($activeTpls,$tpl->get('templateid'));
}

// get the modResources using those tpls
$res = array();
foreach ($activeTpls as $activeTpl) {
    $resTargets = $modx->getCollection('modResource',array('template' => $activeTpl));
    foreach ($resTargets as $resTarget) {
        array_push($res,$resTarget->get('id'));
    }
}

// get the value of the aside TV in those resources
$matches = array();
foreach ($res as $resId) {
    $resource = $modx->getObject('modResource',$resId);
    $tvValue = $resource->getTVValue('aside');
    $values = explode('||',$tvValue);
    // check if the chunk name is in
    if(in_array($aside->get('name'),$values)) {
        array_push($matches,$resource->get('id'));
    }
}

if ($matches) {
    $o = '';
    foreach ($matches as $match) {
        $o .= $match.',';
    }
    return $modx->error->failure($modx->lexicon('asides.aside_err_remove_in_use',array('ids' => trim($o,','))));
}

if ($aside->remove() == false) {
    return $modx->error->failure($modx->lexicon('asides.aside_err_remove'));
}

// output
return $modx->error->success('',$aside);