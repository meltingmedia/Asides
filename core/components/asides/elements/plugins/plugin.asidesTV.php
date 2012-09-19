<?php

$corePath = $modx->getOption('asides.core_path', null, $modx->getOption('core_path').'components/asides/');
switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath.'elements/tv/input/');
        break;

    case 'OnDocFormPrerender':
        $modx->controller->addHtml('<script type="text/javascript">
    Ext.applyIf(MODx.lang, '. $modx->toJSON($modx->lexicon->loadCache('asides', 'default')) .');
</script>');
        $modx->regClientStartupScript($modx->getOption('asides.assets_url') . 'js/mgr/asides.js');
        $modx->regClientStartupScript($modx->getOption('asides.assets_url') . 'js/mgr/tv/asides.tv.js');
        break;
}
return;