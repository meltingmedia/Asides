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
 * Adds events to asideTV plugin
 *
 * @package asides
 * @subpackage build
 */
$events = array();

$events['OnTVInputRenderList']= $modx->newObject('modPluginEvent');
$events['OnTVInputRenderList']->fromArray(array(
    'event' => 'OnTVInputRenderList',
    'priority' => 0,
    'propertyset' => 0,
), '', true, true);

return $events;