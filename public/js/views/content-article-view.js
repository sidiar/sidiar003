
var ContentArticleView = ContentView.extend({
    
    childEvents: {
        "change #selectSection": "sectionChange"
    },
    
    
    sectionChange: function(event) {
        console.log('selectSection',this.$('#selectSection').val());
        this.model.contentModel.save({
            section_id: this.$('#selectSection').val()
        });
    }
    
    
    
    
});
