<?php
/**
 * Asides
 *
 * Copyright 2011 by Romain Tripault // Melting Media <romain@melting-media.com>
 *
 * Asides is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Asides is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Asides; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package asides
 */
/**
 * Add snippets to build
 * 
 * @package asides
 * @subpackage build
 */
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'getAside',
    'description' => 'Grabs the list of chunks to be used as aside items in aside TV',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/getAside.php'),
),'',true,true);

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'showAside',
    'description' => 'Renders the selected chunks',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/showAside.php'),
),'',true,true);
$properties = include $sources['build'].'properties/properties.showAside.php';
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;