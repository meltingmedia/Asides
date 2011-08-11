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
 * Get a list of asides chunks
 *
 * @package asides
 * @subpackage processors
 */
$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start',$_REQUEST,0);
$limit = $modx->getOption('limit',$_REQUEST,20);
$sort = $modx->getOption('sort',$_REQUEST,'name');
$dir = $modx->getOption('dir',$_REQUEST,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

$c = $modx->newQuery('modChunk', array('category' => $modx->getOption('asides.categoryId')));

if (!empty($query)) {
    $c->where(array(
        'name:LIKE' => '%'.$query.'%',
        /*'OR:description:LIKE' => '%'.$query.'%',
        'OR:city:LIKE' => '%'.$query.'%',
        'OR:date:LIKE' => '%'.$query.'%',*/
    ));
}

$count = $modx->getCount('modChunk',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$asides = $modx->getCollection('modChunk',$c);

$list = array();
foreach ($asides as $aside) {
    $asideArray = $aside->toArray();
    $list[]= $asideArray;
}
return $this->outputArray($list,$count);