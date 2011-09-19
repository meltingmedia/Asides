Ext.onReady(function() {
    MODx.load({ xtype: 'asides-page-aside'});
    MODx.loadRTE('ta');
});

Asides.page.Aside = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: 'Back'
            ,id: 'adx-btn-back'
            ,handler: function() {
                location.href = '?a='+Asides.action;
            }
            ,scope: this
        },{
            text: 'Help'
        }]
        ,components: [{
            xtype: 'asides-panel-aside'
            ,renderTo: 'asides-panel-aside-div'
        }]
    });
    Asides.page.Aside.superclass.constructor.call(this,config);
};
Ext.extend(Asides.page.Aside,MODx.Component);
Ext.reg('asides-page-aside',Asides.page.Aside);