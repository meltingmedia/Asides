<?php
/**
 * showAside
 *
 * Display all selected chunks
 *
 * @var modX $modx
 * @var array $scriptProperties
 * @package asides
 */
$Asides = $modx->getService('asides', 'Asides', $modx->getOption('asides.core_path', null, $modx->getOption('core_path').'components/asides/').'model/asides/', $scriptProperties);
if (!($Asides instanceof Asides)) return '';

if (!isset($scriptProperties['source']) || strpos($scriptProperties['source'], '[[') !== false) {
    return 'please, define a TV to check'; //@TODO: i18n
}
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$wrapper = isset($wrapper) ? $wrapper : 'aside.wrapper';
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);
$prefix = $modx->getOption('asides.prefix', $scriptProperties, 'aside.');

$ar_chunks = explode('||', $source);
$ar_chunks = array_unique($ar_chunks);
$total = count($ar_chunks);

$output = '';
$list = array();

$idx = 1;
foreach ($ar_chunks as $chunk) {
    if ($chunk != '') {
        $first = ($idx === 1) ? true : false;
        $last = ($idx === $total) ? true : false;
        if ($wrapper) {
            // we are wrapping the chunk with another chunk (layout purpose)
            $chunkobj = $modx->getObject('modChunk', array('name' => $chunk));
            $id = $chunkobj->get('id');
            $props = $chunkobj->getProperties();
            $before = $props['before'];
            $after = $props['after'];
            $c = $Asides->getChunk($wrapper, array(
                $prefix.'content' => $Asides->getChunk($chunk),
                $prefix.'id' => $id,
                $prefix.'before' => $before,
                $prefix.'after' => $after,
                $prefix.'idx' => $idx,
                $prefix.'first' => $first,
                $prefix.'last' => $last,
                $prefix.'total' => $total,
            ));
        } else {
            // just get the chunk
            $c = $Asides->getChunk($chunk);
        }

        if ($c) {
            $list[] = $c;
        }
        $idx++;
    }
}


$output = implode($list, $outputSeparator);

if (!empty($toPlaceholder)) {
    // if using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}

return $output;
