<div id="tv{$tv->id}-asides" style="width: 100%;"></div>

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

    var grid{/literal}{$tv->id}{literal} = new Ext.grid.GridPanel({
        store: store{/literal}{$tv->id}{literal}
        ,columns: [{
            id: 'label'
            ,header: _('asides.column_name')
            ,dataIndex: 'label'
//            ,width: 1303 - 80
//            ,fixed: true
        },{
            id: 'checked'
            ,header: _('asides.column_active')
            ,dataIndex: 'checked'
            ,width: 80
            ,fixed: true
        }]
        ,listeners: {
            click: {
                fn: MODx.fireResourceFormChange
                ,scope: this
            }
        }
        ,viewConfig: {
            forceFit: true
            ,enableRowBody: true
            ,autoFill: true
            ,headersDisabled: true
        }
        ,anchor: '100%'
        ,autoHeight: true
        ,stripeRows: true
        //,frame: true
        ,enableDragDrop: true
        ,enableHdMenu: false
        ,enableColumnMove: false
        ,enableColumnResize: false
        ,enableColumnHide: false
        //,forceLayout: true

        ,ddGroup: 'asidesGroup'
        ,ddText: _('asides.entry_sort')
        ,renderTo: {/literal}'tv{$tv->id}-asides'{literal}
//        ,tbar: ['->', {
//            xtype: 'button'
//            ,text: 'test'
//        }]
    });

    // Dropzone
    var ddrow{/literal}{$tv->id}{literal} = new Ext.dd.DropTarget(
        grid{/literal}{$tv->id}{literal}.getView().mainBody, {
        ddGroup: 'asidesGroup'
        ,notifyDrop: function(dd, e, data) {
            var sm = grid{/literal}{$tv->id}{literal}.getSelectionModel();
            var rows = sm.getSelections();
            var cindex = dd.getDragData(e).rowIndex;
            var store = grid{/literal}{$tv->id}{literal}.getStore();
            var checkbox_id = null;
            var cb = null;
            if (sm.hasSelection()) {
                for (i = 0; i < rows.length; i ++) {
                    checkbox_id = store.getById(rows[i].id).data.id;
                    cb_checked = Ext.get(checkbox_id).dom.checked;
                    store.remove(store.getById(rows[i].id));
                    store.insert(cindex,rows[i]);
                    Ext.get(checkbox_id).dom.checked=cb_checked;
                }
                sm.selectRecords(rows);
            }
        }
    });

    //console.log(grid{/literal}{$tv->id}{literal});
});
{/literal}
// ]]>
</script>