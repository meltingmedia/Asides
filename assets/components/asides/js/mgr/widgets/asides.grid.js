Asides.grid.Items = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        id: 'asides-grid-items'
        ,url: Asides.config.connector_url
        ,baseParams: {
            action: 'mgr/asides/getlist'
        }
        ,fields: ['id','name','description','snippet','locked']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: _('name')
            ,dataIndex: 'name'
        },{
            header: _('description')
            ,dataIndex: 'description'
        },{
            header: _('locked')
            ,dataIndex: 'locked'
        }]
        ,tbar: [{
            xtype: 'textfield'
            ,id: 'asides-search-filter'
            ,emptyText: _('asides.search')+'…'
            ,listeners: {
                'change': {
                    fn: this.search
                    ,scope:this
                }
                ,'render': {
                    fn: function(cmp) {
                        new Ext.KeyMap(cmp.getEl(), {
                            key: Ext.EventObject.ENTER
                            ,fn: function() {
                                this.fireEvent('change', this);
                                this.blur();
                                return true;
                            }
                            ,scope: cmp
                        });
                    }
                    ,scope:this}
            }
        }
        ,{
            xtype: 'button'
            ,id: 'asides-search-clear'
            ,itemId: 'clear'
            ,text: _('asides.search_clear')
            ,listeners: {
                'click': {
                    fn: this.clearFilter
                    ,scope: this
                }
            }
        }]
    });
    Asides.grid.Items.superclass.constructor.call(this, config);
};
Ext.extend(Asides.grid.Items, MODx.grid.Grid, {
    windows: {}

    ,search: function(tf, nv ,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,clearFilter: function() {
        this.getStore().baseParams = {
            action: 'mgr/asides/getlist'
        };
        Ext.getCmp('asides-search-filter').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,getMenu: function() {
        var m = [];
        if (this.menu.record.locked != _('yes') || Asides.editLocked == 1 ) {
            m.push({
                text: _('asides.aside_update')
                ,handler: this.updateAside
            });
            m.push('-');
        }
        m.push({
            text: _('asides.aside_clear')
            ,handler: this.clearAside
        });
        m.push('-');
        m.push({
            text: _('asides.aside_remove')
            ,handler: this.removeAside
        });
        this.addContextMenuItem(m);
    }
    ,updateAside: function(btn ,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;
        window.location = 'index.php?a='+Asides.action+'&action=aside&id='+this.menu.record.id;
    }
    ,clearAside: function(btn ,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('asides.aside_clear')
            ,text: _('asides.aside_clear_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/asides/clear'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {
                    fn: function(r) {
                        this.refresh();
                    }
                    ,scope:this
                }
            }
        });
    }
    ,removeAside: function(btn ,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('asides.aside_remove')
            ,text: _('asides.aside_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/asides/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {
                    fn: function(r) {
                        this.refresh();
                    }
                    ,scope:this
                }
            }
        });
    }
});
Ext.reg('asides-grid-items', Asides.grid.Items);