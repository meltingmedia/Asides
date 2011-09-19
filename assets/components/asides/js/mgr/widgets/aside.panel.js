Asides.panel.Aside = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};

    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('asides.menu')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: /*_('asides.items')*/'Create/edit'
                ,items: [{
                    layout: 'form'
                    ,labelWidth: 150
                    ,border: false
                    ,id: 'asides-aside-edit'
                    ,items: [{
                        xtype: 'statictextfield'
                        ,fieldLabel: 'ID'
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
                        xtype: 'textarea'
                        ,name: 'snippet'
                        //,id: 'asides-'+this.ident+'-snippet'
                        ,id: 'ta'
                        ,anchor: '90%'
                    }]
                }]
            },{
                title: 'Property sets'
                ,items: [{
                    layout: 'form'
                    ,labelWidth: 150
                    ,border: false
                    ,id: 'asides-aside-ps'
                    ,items: [{
                        xtype: 'textarea'
                        ,fieldLabel: /*_('name')*/'Before'
                        ,description: 'Things to do/display before the content'
                        ,name: 'before'
                        ,id: 'asides-'+this.ident+'-before'
                        ,anchor: '90%'
                        ,grow: true
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: /*_('description')*/'After'
                        ,description: 'Things to do/display after the content'
                        ,name: 'after'
                        ,id: 'asides-'+this.ident+'-after'
                        ,anchor: '90%'
                        ,grow: true
                    }]
                }]
            }]
        }]
    });
    Asides.panel.Aside.superclass.constructor.call(this,config);
};

Ext.extend(Asides.panel.Aside, MODx.Panel);
Ext.reg('asides-panel-aside', Asides.panel.Aside);