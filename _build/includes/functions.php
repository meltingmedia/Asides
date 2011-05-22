<?php
/**
 * Required function(s) to build transport packages
 *
 * Copyright 2011 by Shaun McCormick <shaun@modx.com>
 */
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = str_replace('<?php','',$o);
    $o = str_replace('?>','',$o);
    $o = trim($o);
    return $o;
}