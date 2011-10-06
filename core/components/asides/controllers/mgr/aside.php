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
 * Loads the aside "edit" page.
 *
 * @package asides
 * @subpackage controllers
 */

$create = (empty($_REQUEST['id'])) ? true : false;
$fullview = $modx->hasPermission('edit_locked');

$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/widgets/aside.panel.js');
$modx->regClientStartupScript($asides->config['jsUrl'].'mgr/sections/aside.js');
$asides->loadRichTextEditor();

$record = array();
if (!$create) {
    // updating an aside
    $aside = $modx->getObject('modChunk', array(
        'id' => $_REQUEST['id'],
        'category' => $modx->getOption('asides.categoryId')
    ));
    if (!$aside) return 'error'; //@TODO: i18n error msg
    $record = $aside->toArray();
    // Get the property sets
    $properties = $aside->getProperties();
    foreach ($properties as $k => $v) {
        $record[$k] = $v;
    }
}

$modx->regClientStartupHTMLBlock('
<script type="text/javascript">
var fullview = '.($fullview ? 1 : 0).';
// <![CDATA[
Ext.onReady(function() {
    MODx.load({
        xtype: "asides-page-aside"
        ,record: '.$modx->toJSON($record).'
    });
    MODx.loadRTE("ta");
});
// ]]>
</script>');

$output = '<div id="asides-panel-aside-div"></div>';

return $output;