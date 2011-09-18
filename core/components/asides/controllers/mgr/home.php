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
 * Loads the home page.
 *
 * @package asides
 * @subpackage controllers
 */
$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/widgets/asides.grid.js');
$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/sections/home.js');
$asides->loadRichTextEditor();

$hasPerm = $modx->hasPermission('edit_locked');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
var editLocked = '.($hasPerm ? 1 : 0).';
/*Ext.onReady(function() {
    MODx.loadRTE("ta");
});*/</script>');

$output = '<div id="asides-panel-home-div"></div>';

return $output;
