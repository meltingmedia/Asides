
Asides.grid.AsidesTV =  function(config) {
    config = config || {};

    Ext.applyIf(config, {
        columns: [{
            id: 'label'
            ,header: _('asides.column_name')
            ,dataIndex: 'label'
        },{
            id: 'checked'
            ,header: _('asides.column_active')
            ,dataIndex: 'checked'
            ,width: 80
            ,fixed: true
        }]
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
        ,ddGroup: 'asidesGroup'
        ,ddText: _('asides.entry_sort')
        ,enableHdMenu: false
        ,enableColumnMove: false
        ,enableColumnResize: false
        ,enableColumnHide: false
//        ,tbar: ['->', {
//            xtype: 'button'
//            ,text: 'test'
//        }]

        ,listeners: {
            click: {
                fn: function() {
                    MODx.fireResourceFormChange();
                    console.log(this.getStore());
                }
                ,scope: this
            }
        }
    });
    Asides.grid.AsidesTV.superclass.constructor.call(this, config);

    new Ext.dd.DropTarget(this.getView().mainBody, {
        ddGroup: 'asidesGroup'
        ,notifyDrop: function(source, e, data) {
            MODx.fireResourceFormChange();
            var sm = source.grid.getSelectionModel();
            var rows = sm.getSelections();
            var cindex = source.getDragData(e).rowIndex;
            var store = source.grid.getStore();
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
};

//Ext.extend(Asides.grid.AsidesTV, MODx.grid.LocalGrid, {
Ext.extend(Asides.grid.AsidesTV, Ext.grid.GridPanel);
Ext.reg('asides-grid', Asides.grid.AsidesTV);
