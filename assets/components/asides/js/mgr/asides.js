var Asides = function(config) {
    config = config || {};
    Asides.superclass.constructor.call(this,config);
};
Ext.extend(Asides,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('asides',Asides);

Asides = new Asides();