<?php
/**
 * @package asides
 * @subpackage controllers
 */
class AsidesHomeManagerController extends AsidesManagerController {
    public function process(array $scriptProperties = array()) {

    }

    public function getPageTitle() { return $this->modx->lexicon('asides'); }

    public function loadCustomCssJs() {
//        $this->addJavascript($this->asides->config['js_url'].'mgr/widgets/home/cmpitem.grid.js');
//        $this->addJavascript($this->asides->config['js_url'].'mgr/widgets/home/home.panel.js');
//        $this->addJavascript($this->asides->config['js_url'].'mgr/sections/home.page.js');

        $this->addJavascript($this->asides->config['jsUrl'].'mgr/widgets/asides.grid.js');
        $this->addJavascript($this->asides->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addJavascript($this->asides->config['jsUrl'].'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.load({
                    xtype: "asides-page-home"
                });
            });
        </script>');
    }

    public function getTemplateFile() { return $this->asides->config['templates_path'] . 'home.tpl'; }
}