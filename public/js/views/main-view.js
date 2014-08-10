var MainView = Backbone.View.extend({
    
    events: {
        "click #option_articles,#option_diapos,#option_links,#option_fav,#option_sections,#option_newsletter": "selectSection"
    },
    
    selectSection: function(event) {
        var option_id = $(event.target).attr('id');
        
        this.unselectAll();
        $('#'+option_id).addClass('selected-option');
        
        switch(option_id) {
            case 'option_articles':
                this.model.urlModel.set({
                    controller : 'articles'
                })
                break;
            case 'option_diapos':
                this.model.urlModel.set({
                    controller : 'diapos'
                })
                break;
        }
        
        this.loadDynamicContent('/index');
    },
    
    unselectAll: function () {
       $('#option_articles,#option_diapos,#option_links,#option_fav,#option_sections,#option_newsletter').removeClass('selected-option');
    },
    
    loadDynamicContent: function(params) { 
        if (typeof(params) != "undefined") {
            this.model.urlModel.set({
                params : params
            });
        } else {
            this.model.urlModel.set({
                params : ''
            });
        }
        this.model.urlModel.set({
                page : ''
        });
            
        $('#content-dynamic').load(this.model.urlModel.getURL());
    },
    
    loadPage: function (pageNumber) {
        this.model.urlModel.set({
            page : pageNumber
        });
        $('#content-dynamic').load(this.model.urlModel.getURL());

    },
    
    loadPrevContent: function() {
        $('#content-dynamic').load(this.model.urlModel.getPrevURL());
    },
    
    refresh: function () {
        $('#content-dynamic').load(this.model.urlModel.getURL());

    },
    
    clearModals: function() {
        /* se asegura de restablecer el fondo al volver de un modal*/
        $('.modal-backdrop').removeClass("modal-backdrop");
    }
    
    
    
});