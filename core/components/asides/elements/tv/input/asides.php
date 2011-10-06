<?php
/**
 * checkboxSortable
 *
 * @author : MadeMyDay - https://github.com/MadeMyDay/checkboxSortable
 * @package modx
 * @subpackage processors.element.tv.renders.mgr.input
*/

$this->xpdo->lexicon->load('tv_widget','asides:default');
$corePath = $modx->getOption('asides.core_path', null, $modx->getOption('core_path').'components/asides/');

$default = explode('||', $this->get('default_text')); // all standard values
$value = trim($value);
$value = empty($value) ? $default : explode('||', $value); // current saved values or default

$index_list = $this->parseInputOptions($this->processBindings($this->get('elements'), $this->get('name')));

$inputoptions = array();
foreach ($index_list as $inputoption){
    $inputopt_array = (is_array($inputoption)) ? $inputoption : explode('==', $inputoption);
    $option['value'] = isset($inputopt_array[1])? $inputopt_array[1] : $inputopt_array[0];
    $option['text'] = htmlspecialchars($inputopt_array[0], ENT_COMPAT, $modx->getOption('modx_charset'));
    $option['checked'] = false;
    $inputoptions[$option['value']] = $option;
}

$options = array();
if (!empty($value[0]) && count($value) > 0){
    foreach ($value as $itemvalue){
        $option = $inputoptions[$itemvalue];
        $option['checked'] = true;
        $options[] = $option;
        unset($inputoptions[$itemvalue]);
    }
}

$options = count($options) > 0 ? array_merge($options, $inputoptions) : $inputoptions;

$this->xpdo->smarty->assign('opts', $options);
$modx->smarty->assign('checkboxsortable', $this->xpdo->lexicon->fetch() );
return $this->xpdo->smarty->fetch($corePath.'elements/tv/asides.tpl');