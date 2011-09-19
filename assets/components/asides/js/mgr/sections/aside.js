Asides.page.Aside = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};

    Ext.applyIf(config,{
        formpanel: 'asides-panel-aside'
        ,url: Asides.config.connector_url
        ,buttons: [{
            text: config.record.id ? 'Save' : 'Create'
            ,id: 'asides-btn-save'
            ,process: config.record.id ? 'mgr/asides/update' : 'mgr/asides/create'
            ,method: 'remote'
            ,keys: [{
                key: MODx.config.keymap_save || 's'
                ,ctrl: true
            }]
        },{
            text: 'Delete'
            ,id: 'asides-btn-delete'
            ,handler: function() {
                if (!config.record.id) return;
                MODx.msg.confirm({
                    title: _('adx.aside_remove')
                    ,text: _('adx.aside_remove_confirm')
                    ,url: config.url
                    ,params: {
                        action: 'mgr/asides/remove'
                        ,id: config.record.id
                    }
                    ,listeners: {
                        'success': {
                            fn: function() {
                                location.href = '?a='+Asides.action;
                            }
                            ,scope: this
                        }
                    }
                });
            }
        },{
            text: 'Back'
            ,id: 'asides-btn-back'
            ,handler: function() {
                location.href = '?a='+Asides.action;
            }
            ,scope: this
        },'-',{
            text: 'Help'
            ,id: 'asides-btn-help'
        }]
        ,components: [{
            xtype: 'asides-panel-aside'
            ,renderTo: 'asides-panel-aside-div'
            ,record: config.record || {}
        }]
    });
    Asides.page.Aside.superclass.constructor.call(this,config);
};
Ext.extend(Asides.page.Aside,MODx.Component);
Ext.reg('asides-page-aside',Asides.page.Aside);