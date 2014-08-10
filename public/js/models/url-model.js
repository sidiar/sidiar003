
var URLModel = Backbone.Model.extend({
    
    getURL: function() {
   
        var controller = this.get('controller');
        
        if (controller==='') return;
        
        var result = '/' + controller;
        result += this.get('params');
        
        if (this.get('page')) {
            result += '/page/' + this.get('page');
        }
        console.log('geturl ',result);
        return result;
    },
    
    saveURL: function() {
        this.saveAttributes = {
            controller : this.get('controller'),
            page : this.get('page'),
            params : this.get('params')
        };
    },
    
    getPrevURL: function() {
        this.set({
            controller:this.saveAttributes.controller,
            page:this.saveAttributes.page,
            params:this.saveAttributes.params
        });
        return this.getURL();
    }
    
    
});