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
            ,width: 200
        },{
            header: _('description')
            ,dataIndex: 'description'
            ,width: 250
        },{
            header: _('locked')
            ,dataIndex: 'locked'
            ,width: 70
        }]
        ,tbar: [{
            text: _('asides.aside_create')
            ,handler: this.createAside
            ,scope: this
        }]
    });
    Asides.grid.Items.superclass.constructor.call(this,config);
};
Ext.extend(Asides.grid.Items,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        // @TODO: check if user have edit_locked right
        if (this.menu.record.locked != 1) {
            m.push({
                text: _('asides.aside_update')
                ,handler: this.updateAside
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
        ,height: 150
        ,width: 875
        ,url: Asides.config.connector_url
        ,action: 'mgr/asides/create'
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'asides-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'asides-'+this.ident+'-description'
            ,width: 300
        },{
            xtype: 'asides-rte'
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
        ,height: 150
        ,width: 475
        ,url: Asides.config.connector_url
        ,action: 'mgr/asides/update'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'asides-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'asides-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'asides-'+this.ident+'-description'
            ,width: 300
        },{
            xtype: 'asides-rte'
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
        ,name: 'snippet'
        ,id: 'asides-'+this.ident+'-snippet'
        ,width: 800
        ,tinymceSettings: {
            theme: "advanced"
            ,skin: "cirkuit"
            //,plugins: "style,advimage,advlink,modxlink,searchreplace,print,contextmenu,paste,fullscreen,noneditable,nonbreaking,xhtmlxtras,visualchars,media"
            ,plugins: "style,advimage,advlink,modxlink,searchreplace,print,contextmenu,paste,fullscreen,noneditable,nonbreaking,xhtmlxtras,visualchars,media,template"
            ,theme_advanced_buttons1: "undo,redo,selectall,separator,nonbreaking,charmap,separator,image,modxlink,unlink,anchor,media,separator,fullscreen,code,help"
            ,theme_advanced_buttons2: "bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect,formatselect,separator"
            //,theme_advanced_buttons3: "tablecontrols,template"
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