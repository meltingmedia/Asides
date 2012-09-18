<?php

$corePath = $modx->getOption('asides.core_path', null, $modx->getOption('core_path').'components/asides/');
switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath.'elements/tv/input/');
        break;
}
return;