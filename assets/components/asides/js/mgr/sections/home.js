Ext.onReady(function() {
    MODx.load({ xtype: 'asides-page-home'});
});

Asides.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'asides-panel-home'
            ,renderTo: 'asides-panel-home-div'
        }]
    }); 
    Asides.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Asides.page.Home,MODx.Component);
Ext.reg('asides-page-home',Asides.page.Home);