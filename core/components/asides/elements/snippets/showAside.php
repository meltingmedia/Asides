<?php
/**
 * showAside
 *
 * Display all selected chunks
 *
 * @package asides
 */

if (!isset($scriptProperties['chunks'])) {
    return '';
}

$ar_chunks = explode('||',$chunks);
$ar_chunks = array_unique($ar_chunks);

$output = '';
$list = array();

foreach ($ar_chunks as $chunk) {
    if ($chunk != '') {
        $c = $modx->getChunk($chunk);
        if ($c) {
            $list[] = $c;
        }
        //$output .= $c;
    }
}

$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");
$output = implode($list,$outputSeparator);

return $output;