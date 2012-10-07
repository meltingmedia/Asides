
Asides.grid.AsidesTV =  function(config) {
    config = config || {};

    Ext.applyIf(config, {
        anchor: '100%'
        //,fields: ['label', 'checked']
        ,columns: [{
            header: _('asides.column_name')
            ,dataIndex: 'label'
        },{
            header: _('asides.column_active')
            ,dataIndex: 'checked'
            ,width: 80
            ,fixed: true
        }]
        ,enableColumnMove: false
        ,enableDragDrop: true
        ,enableHdMenu: false
        ,ddGroup: 'asidesGroup'
        ,ddText: _('asides.entry_sort')
        //,frame: true
        ,store: this._loadStore(config)

        ,tbar: ['->', {
            xtype: 'button'
            ,text: 'test'
        }]

        ,listeners: {
            click: {
                //fn: MODx.fireResourceFormChange
                fn: this.testMe
                ,scope: this
            }
        }
    });
    Asides.grid.AsidesTV.superclass.constructor.call(this, config);
    //console.log(this);
};

//Ext.extend(Asides.grid.AsidesTV, MODx.grid.LocalGrid, {
Ext.extend(Asides.grid.AsidesTV, Ext.grid.GridPanel, {
    _loadStore: function(config) {
        console.log(config.storeTest);
        this.store = config.storeTest;

        return this.store;
    }

    ,testMe: function() {
        console.log(this.getStore());
        MODx.fireResourceFormChange();
    }
});
Ext.reg('asides-grid', Asides.grid.AsidesTV);
