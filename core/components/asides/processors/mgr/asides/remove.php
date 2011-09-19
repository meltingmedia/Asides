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
 * Remove an aside chunk.
 *
 * @package asides
 * @subpackage processors
 */

$Asides = $modx->getService('asides','Asides',$modx->getOption('asides.core_path',null,$modx->getOption('core_path').'components/asides/').'model/asides/',$scriptProperties);
if (!($Asides instanceof Asides)) return '';

if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('asides.aside_err_ns'));
$aside = $modx->getObject('modChunk', $scriptProperties['id']);
if (!$aside) return $modx->error->failure($modx->lexicon('asides.aside_err_nf'));

// check if in use
$o = $Asides->inResource($aside);
if ($o) {
    return $modx->error->failure($modx->lexicon('asides.aside_err_remove_in_use', array('ids' => $o)));
}

if ($aside->remove() == false) {
    return $modx->error->failure($modx->lexicon('asides.aside_err_remove'));
}

// output
return $modx->error->success('', $aside);