<div id="tv{$tv->id}-asides" style="width:97%;"></div>

<script type="text/javascript">
// <![CDATA[
{literal}
Ext.onReady(function() {

    var store{/literal}{$tv->id}{literal} = new Ext.data.Store({
        autoDestroy: true
        ,reader: new Ext.data.ArrayReader({}, [
            {name: 'id'}
            ,{name: 'name'}
            ,{name: 'value'}
            ,{name: 'label'}
            ,{name: 'checked'}
        ])
        ,data: [{/literal}
    {foreach from=$opts item=item key=k name=asides}
        {literal}[{/literal}
        'tv{$tv->id}-{$k}',
        'tv{$tv->id}[]',
        '{$item.value}',
        '{$item.text|escape:"javascript"}',
        '<center><input id="tv{$tv->id}-{$k}" type="checkbox" value="{$item.value}" name="tv{$tv->id}[]" {if $item.checked}checked{/if} /></center>'
        {literal}],{/literal}
    {/foreach}
    {literal}]
    });

    var aside{/literal}{$tv->id}{literal} = MODx.load({
        xtype: 'asides-grid'
        ,renderTo: {/literal}'tv{$tv->id}-asides'{literal}
        ,storeTest: store{/literal}{$tv->id}{literal}
    });

    Ext.getCmp('modx-panel-resource').getForm().add(aside{/literal}{$tv->id}{literal});
});
{/literal}
// ]]>
</script>