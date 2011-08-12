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
            ,emptyText: 'Search…'
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }
        // clear filter (source: lexicon grid)
        ,{
            xtype: 'button'
            ,id: 'asides-search-clear'
            ,itemId: 'clear'
            ,text: 'Clear search'
            ,listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }
        // align right
        ,'-'
        ,{
            text: _('asides.aside_create')
            ,handler: this.createAside
            ,scope: this
        }]
    });
    Asides.grid.Items.superclass.constructor.call(this,config);
};
Ext.extend(Asides.grid.Items,MODx.grid.Grid,{
    windows: {}
    // for search
    ,search: function(tf,nv,ov) {
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
        if (this.menu.record.locked != 1 || editLocked == 1 ) {
            m.push({
                text: _('asides.aside_update')
                ,handler: this.updateAside
            });
            m.push('-');
            m.push({
                text: _('asides.aside_clear')
                ,handler: this.clearAside
            });
            m.push('-');
            m.push({
                text: _('asides.aside_remove')
                ,handler: this.removeAside
            });
        }
        this.addContextMenuItem(m);
    }

    ,createAside: function(btn,e) {
        if (!this.windows.createAside) {
            this.windows.createAside = MODx.load({
                xtype: 'asides-window-aside-create'
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.createAside.fp.getForm().reset();
        this.windows.createAside.show(e.target);
    }
    ,updateAside: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        if (!this.windows.updateAside) {
            this.windows.updateAside = MODx.load({
                xtype: 'asides-window-aside-update'
                ,record: r
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.updateAside.fp.getForm().reset();
        this.windows.updateAside.fp.getForm().setValues(r);
        this.windows.updateAside.show(e.target);
    }
    ,clearAside: function(btn,e) {
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
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
    ,removeAside: function(btn,e) {
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
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
});
Ext.reg('asides-grid-items',Asides.grid.Items);




Asides.window.CreateAside = function(config) {
    config = config || {};
    this.ident = config.ident || 'acaside'+Ext.id();
    Ext.applyIf(config,{
        title: _('asides.aside_create')
        ,id: this.ident
        ,url: Asides.config.connector_url
        ,action: 'mgr/asides/create'
        ,collapsible: false
        ,width: '650'
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'asides-'+this.ident+'-name'
            ,anchor: '90%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'asides-'+this.ident+'-description'
            ,anchor: '90%'
        },{
            xtype: 'asides-rte'
            ,name: 'snippet'
            ,id: 'asides-'+this.ident+'-snippet'
            ,anchor: '90%'
        }]
    });
    Asides.window.CreateAside.superclass.constructor.call(this,config);
};
Ext.extend(Asides.window.CreateAside,MODx.Window);
Ext.reg('asides-window-aside-create',Asides.window.CreateAside);


Asides.window.UpdateAside = function(config) {
    config = config || {};
    this.ident = config.ident || 'auaside'+Ext.id();
    Ext.applyIf(config,{
        title: _('asides.aside_update')
        ,id: this.ident
        ,url: Asides.config.connector_url
        ,action: 'mgr/asides/update'
        ,collapsible: false
        ,width: '650'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'asides-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'asides-'+this.ident+'-name'
            ,anchor: '90%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'asides-'+this.ident+'-description'
            ,anchor: '90%'
        },{
            xtype: 'asides-rte'
            ,name: 'snippet'
            ,id: 'asides-'+this.ident+'-snippet'
            ,anchor: '90%'
        }]
    });
    Asides.window.UpdateAside.superclass.constructor.call(this,config);
};
Ext.extend(Asides.window.UpdateAside,MODx.Window);
Ext.reg('asides-window-aside-update',Asides.window.UpdateAside);


// TinyMCE for Asides edition
Asides.tinymce = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name : 'asides_rte'
        ,fieldLabel: _('asides.aside.content')
        ,tinymceSettings: {
            theme: "advanced"
            ,skin: "cirkuit"
            ,plugins: "style,advimage,advlink,modxlink,searchreplace,print,contextmenu,paste,fullscreen,noneditable,nonbreaking,xhtmlxtras,visualchars,media,template"
            ,theme_advanced_buttons1: "undo,redo,selectall,separator,nonbreaking,charmap,separator,image,modxlink,unlink,anchor,media,separator,fullscreen,code,help"
            ,theme_advanced_buttons2: "bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,template"
            ,theme_advanced_buttons3: "styleselect,formatselect"
            ,theme_advanced_toolbar_location: "top"
            ,theme_advanced_toolbar_align: "left"
            ,theme_advanced_statusbar_location: "bottom"
            ,theme_advanced_resizing: false
            ,extended_valid_elements: "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
        }
    });
    Asides.tinymce.superclass.constructor.call(this, config);
};
Ext.extend(Asides.tinymce, Ext.ux.TinyMCE);
Ext.reg('asides-rte', Asides.tinymce);