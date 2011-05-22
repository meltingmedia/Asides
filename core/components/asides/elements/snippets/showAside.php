<?php
/**
 * showAside
 *
 * @package asides
 */

$ar_chunks = explode('||',$chunks);
$ar_chunks = array_unique($ar_chunks);

$output = '';

foreach ($ar_chunks as $chunk) {
    if ($chunk != '') {
        $c = $modx->getChunk($chunk);
        if ($c) $output .= $c;
    }
}

return $output;