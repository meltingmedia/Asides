<?php
/**
 * getAside
 *
 * @package asides
 */

$chunkArray = $modx->getCollection('modChunk',array(
    'category' => $modx->getOption('asides.categoryId')
));

$chunkNames = array();

/* Put the chunk names into the array */
foreach($chunkArray as $chunk) {
    $chunkNames[] = $chunk->get('name');
}

/* Format the chunknames as a delimited string for the TV */
$l_chunks = implode('||',$chunkNames);
return $l_chunks;