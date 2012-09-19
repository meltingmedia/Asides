Asides.panel.Aside = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};

    var tabs = [];
    // Create/edit
    tabs.push({
        title: _('asides.aside_create_edit')
        ,cls: 'modx-resource-tab'
        ,layout: 'form'
        //,bodyStyle: 'padding: 15px;'
        ,bodyCssClass: 'main-wrapper'
        ,autoHeight: true
        ,defaults: {
            border: false
            ,labelWidth: 150
        }
        ,items: [{
            layout: 'form'
            ,id: 'asides-aside-edit'
            ,items: [{
                xtype: config.record.id ? 'statictextfield' : 'hidden'
                ,fieldLabel: 'ID'
                ,name: 'id'
                ,id: 'asides-'+this.ident+'-id'
                ,value: config.record.id
                ,submitValue: true
            },{
                xtype: 'textfield'
                ,fieldLabel: _('name')
                ,name: 'name'
                ,id: 'asides-'+this.ident+'-name'
                ,anchor: '100%'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('description')
                ,name: 'description'
                ,id: 'asides-'+this.ident+'-description'
                ,anchor: '100%'
            },{
                layout: 'column'
                ,border: false
                ,defaults: {
                    border: false
                }
                ,anchor: '90%'
                ,items:[{
                    layout: 'form'
                    ,width: 150
                    ,items: [{
                        id: 'modx-content-below'
                        ,border: false
                    }]
                },{
                    columnWidth: 1
                    ,layout: 'form'
                    ,hideLabels: true
                    ,labelWidth: 0
                    ,items: [{
                        xtype: 'textarea'
                        ,name: 'snippet'
                        ,id: 'ta'
                        ,anchor: '100%'
                        ,grow: true
                    }]
                }]
            }]
        }]
    });

    // Property Sets
    if (Asides.editLocked) {
        tabs.push({
            title: _('asides.aside_properties')
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,bodyCssClass: 'main-wrapper'
            //,bodyStyle: 'padding: 15px;'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,labelWidth: 150
            }
            ,items: [{
                layout: 'form'
                ,id: 'asides-aside-ps'
                ,defaults: {
                    anchor: '100%'
                    ,grow: true
                }
                ,items: [{
                    xtype: 'textarea'
                    ,fieldLabel: _('asides.aside_before')
                    ,description: _('asides.aside_before_desc')
                    ,name: 'before'
                    ,id: 'asides-'+this.ident+'-before'
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('asides.aside_after')
                    ,description: _('asides.aside_after_desc')
                    ,name: 'after'
                    ,id: 'asides-after'
                }]
            }]
        });
    }

    var items = [];
    items.push({
        html: '<h2>' + _('asides.menu') + '</h2>'
        ,border: false
        ,cls: 'modx-page-header'
    });

    items.push(MODx.getPageStructure(tabs));

    Ext.apply(config, {
        border: false
        ,id: 'asides-panel-aside'
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,url: Asides.config.connector_url
        ,baseParams: {}
        ,items: items
        ,listeners: {
            'setup': {
                fn: this.setup
                ,scope: this
            }
            ,'success': {
                fn: this.success
                ,scope:this
            }
        }
    });
    Asides.panel.Aside.superclass.constructor.call(this, config);
};

Ext.extend(Asides.panel.Aside, MODx.FormPanel, {
    initialized: false
    ,setup: function() {
        if (!this.initialized) {
            this.getForm().setValues(this.config.record);
        }
        this.fireEvent('ready');
        this.initialized = true;
    }
    ,success: function(o) {
       //if(!Asides.request.id) {
            //redirect to edit "mode" after successful ad creation
            location.href = '?a=' + Asides.action + '&action=aside&id=' + o.result.object.id;
        //}
    }
});
Ext.reg('asides-panel-aside', Asides.panel.Aside);