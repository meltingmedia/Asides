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
 * Properties for the Asides snippet.
 *
 * @package asides
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'chunks',
        'desc' => 'prop_asides.chunks_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'asides:properties',
    )
    ,array(
        'name' => 'wrapper',
        'desc' => 'prop_asides.wrapper_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'asides:properties',
    )
    ,array(
        'name' => 'outputSeparator',
        'desc' => 'prop_asides.outputseparator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'asides:properties',
    )
    ,array(
        'name' => 'toPlaceholder',
        'desc' => 'prop_asides.toplaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'asides:properties',
    )
);

return $properties;