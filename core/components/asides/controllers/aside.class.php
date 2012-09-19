<?php
/**
 * @package asides
 * @subpackage controllers
 */
class AsidesAsideManagerController extends AsidesManagerController {
    public $record = array();

    public function process(array $scriptProperties = array()) {
//        $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($scriptProperties, true));

        $create = (empty($scriptProperties['id'])) ? true : false;
        $editLocked = $this->modx->hasPermission('edit_locked');

        if (!$create) {
            // updating an aside
            $aside = $this->modx->getObject('modChunk', array(
                'id' => $scriptProperties['id'],
                'category' => $this->modx->getOption('asides.categoryId'),
            ));
            if (!$aside) return 'error'; //@TODO: i18n error msg

            if($aside->get('locked') == 1 && !$editLocked) {
                return 'access denied'; //@TODO: i18n
            }

            $record = $aside->toArray();
            // Get the property sets
            $properties = $aside->getProperties();
            foreach ($properties as $k => $v) {
                $record[$k] = $v;
            }

            $this->record = $record;
        }

    }

    public function getPageTitle() { return $this->modx->lexicon('asides'); }

    public function loadCustomCssJs() {

        $this->addJavascript($this->asides->config['jsUrl'].'mgr/widgets/aside.panel.js');
        $this->addJavascript($this->asides->config['jsUrl'].'mgr/sections/aside.js');
        $this->asides->loadRichTextEditor();

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.load({
                    xtype: "asides-page-aside"
                    ,record: '.$this->modx->toJSON($this->record).'
                });
                MODx.loadRTE("ta");
            });
        </script>');
    }

    public function getTemplateFile() { return $this->asides->config['templates_path'] . 'aside.tpl'; }
}