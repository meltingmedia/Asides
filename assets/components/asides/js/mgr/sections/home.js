Ext.onReady(function() {
    MODx.load({ xtype: 'asides-page-home'});
});

Asides.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: _('asides.aside_create')
            ,id: 'asides-create'
            ,handler: this.createAside
        },'-',{
            text: 'help'
        }]
        ,components: [{
            xtype: 'asides-panel-home'
            ,renderTo: 'asides-panel-home-div'
        }]
    });
    Asides.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(Asides.page.Home, MODx.Component, {
    createAside: function() {
        location.href = '?a='+Asides.action+'&action=aside';
    }
});
Ext.reg('asides-page-home', Asides.page.Home);