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
 * Loads the header for mgr pages.
 *
 * @package asides
 * @subpackage controllers
 */
$modx->regClientCSS($asides->config['cssUrl'].'mgr.css');
$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/asides.js');

$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/jscripts/tiny_mce/tiny_mce.js');
$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/xconfig.js');
$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/tiny.min.js');
$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/Ext.ux.TinyMCE.min.js');

$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Asides.config = '.$modx->toJSON($asides->config).';
    Asides.config.connector_url = "'.$asides->config['connectorUrl'].'";
    Asides.action = "'.(!empty($_REQUEST['a']) ? $_REQUEST['a'] : 0).'";
});
</script>');

return '';