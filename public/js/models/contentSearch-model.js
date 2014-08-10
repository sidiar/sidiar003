
var ContentSearchModel = Backbone.Model.extend({
    
    defaults: {
        "textSearch": '',
        "selectedSection": ''
    },
    
    getActionParams: function () {
     result = '/index';
     
     var textSearch = this.get('textSearch');     
     if (textSearch.length>0) {
       result += '/text/' + textSearch;
     }
     
     var selectedSection = this.get('selectedSection');
     if (selectedSection!=='') {
         result += '/section_id/' + selectedSection;
     }
     
     return result;
     
    }
    
});