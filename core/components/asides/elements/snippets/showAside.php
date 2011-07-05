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
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n\n");
$wrapper = !empty($wrapper) ? $wrapper : '';
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);

$ar_chunks = explode('||',$chunks);
$ar_chunks = array_unique($ar_chunks);

$output = '';
$list = array();

foreach ($ar_chunks as $chunk) {
    if ($chunk != '') {
        if ($wrapper) {
            // we are wrapping the chunk with another chunk (layout purpose)
            $chunkobj = $modx->getObject('modChunk',array('name'=>$chunk));
            $chunkid = $chunkobj->get('id');
            $c = $modx->getChunk($wrapper,array(
                                               'wrapper' => $modx->getChunk($chunk),
                                                'id' => $chunkid,
                                          ));
        } else {
            // just get the chunk
            $c = $modx->getChunk($chunk);
        }

        if ($c) {
            $list[] = $c;
        }
    }
}


$output = implode($list,$outputSeparator);

if (!empty($toPlaceholder)) {
    // if using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}

return $output;