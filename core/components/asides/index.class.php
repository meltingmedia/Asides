<?php
/**
 * @package asides
 * @subpackage controllers
 */
require_once dirname(__FILE__) . '/model/asides/asides.class.php';

class IndexManagerController extends modExtraManagerController {
    public static function getDefaultController() { return 'home'; }
}

abstract class AsidesManagerController extends modManagerController {
    /** @var Asides $asides */
    public $asides;

    public function initialize() {
        $this->asides = new Asides($this->modx);

        //$this->addCss($this->asides->config['css_url'] . 'mgr.css');
        $this->addJavascript($this->asides->config['jsUrl'] . 'mgr/asides.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Asides.config = '. $this->modx->toJSON($this->asides->config) .';
            Asides.action = "'. (!empty($_REQUEST['a']) ? $_REQUEST['a'] : 0) .'";
            Asides.editLocked = '.($this->modx->hasPermission('edit_locked') ? 1 : 0).';
        });
        </script>');
        //return parent::initialize();
        parent::initialize();
    }

    public function getLanguageTopics() {
        return array('asides:default');
    }

    public function checkPermissions() { return true; }
}