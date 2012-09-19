Asides.panel.Home = function(config) {
    config = config || {};

    Ext.apply(config, {
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>' + _('asides.menu') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            //,bodyStyle: 'padding: 10px'
            ,defaults: {
                border: false
                ,autoHeight: true
            }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('asides.items')
                ,items: [{
                    html: _('asides.intro_msg')
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'asides-grid-items'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }]
        }]
    });
    Asides.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Asides.panel.Home, MODx.Panel);
Ext.reg('asides-panel-home', Asides.panel.Home);
