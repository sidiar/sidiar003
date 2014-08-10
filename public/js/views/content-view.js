
var ContentView = Backbone.View.extend({
    
    originalEvents: {
        "change #inputTitle": "titleChange",
        "change #inputText": "textChange",
        "click #showPublishOptionsButton": "showPublishOptionsHandler",
        "click #btn-edit-close": "closeHandler",
        "click ._popup_mainimage_btn": "mainimageBTNHandler",
        "click ._popup_thumbnail_btn": "thumbnailBTNHandler"
    },
    //Override this event hash in
   //a child view
   childEvents: {
   },
   
   events : function() {
      return _.extend({},this.originalEvents,this.childEvents);
   },
   
   
    titleChange: function(event) {
        console.log('title: ', this.$('#inputTitle').val());
        this.model.contentModel.save({
            title: this.$('#inputTitle').val()
        });
    },
    
    textChange: function(event) {
        
        this.model.contentModel.save({
            text: this.$('#inputText').val()
        });
    },
    
    
   mainimageBTNHandler: function(event) {
       
        this.trigger("editMainImage", this.model.contentModel);
   },
    
   thumbnailBTNHandler: function(event) {
        this.trigger("editThumbnail", this.model.contentModel);
   },

      
   /*   PUBLISH OPTIONS   */
    
   showPublishOptionsHandler: function(event) {

      this.trigger("showPublishOptions",this.model.contentModel);
      
   },
   
   statusChange: function(model) {
       
       this.$('#showPublishOptionsButton').removeClass();
       
       this.model.contentModel.set({
           status: model.get('status'),
           publish_date_from: model.get('publish_date_from'),
           publish_date_to: model.get('publish_date_to'),
           expires: model.get('expires')
       });
       console.log('publish_date_from',this.$('#label_publish_date_from').val());
       this.$('#label_publish_date_from').find('span').html(model.get('publish_date_from'));
       this.$('#label_publish_date_to').find('span').html(model.get('publish_date_to'));
       
       
       switch (model.get('status'))
        {
            case '0':
                this.$('#showPublishOptionsButton').text('Not published');
                this.$('#showPublishOptionsButton').addClass('btn btn-status btn-status-off');
                this.$('#label_publish_date_from').hide();
                break;
            
            case '1':
                this.$('#showPublishOptionsButton').text('Published');
                this.$('#showPublishOptionsButton').addClass('btn btn-status btn-status-on');
                this.$('#label_publish_date_from').show();
                break;
            
            case '2':
                this.$('#showPublishOptionsButton').text('Pending');
                this.$('#showPublishOptionsButton').addClass('btn btn-status btn-status-pending');
                this.$('#label_publish_date_from').show();
                break;
            
        }
        
        if (model.get('expires')) {
            this.$('#label_publish_date_to').show();
        }else{
            this.$('#label_publish_date_to').hide();
        }
        
                       


       console.log('statusChange ok')
       /*
       var contentID = model.get('id');
       
       this.model.contentCollection.get(contentID).set({
            status: model.get('status'),
            publish_date_from: model.get('publish_date_from'),
            publish_date_to: model.get('publish_date_to'),
            expires: model.get('expires'),
        });
        
        var contentROW = $("tr[data-value='" + contentID + "']");
        contentROW.find('.showPublishOptionsButton').find('span').removeClass();
        switch (model.get('status'))
        {
            case '0':
               contentROW.find('.showPublishOptionsButton').find('span').addClass('glyphicon glyphicon-remove-circle  list-status-publish-off');
                break;
            
            case '1':
               contentROW.find('.showPublishOptionsButton').find('span').addClass('glyphicon glyphicon-ok-circle  list-status-publish-on');
                break;
            
            case '2':
               contentROW.find('.showPublishOptionsButton').find('span').addClass('glyphicon glyphicon-ok-circle  list-status-publish-pending');
                break;
            
        }
        contentROW.find('.publish_date_from_column').html(model.get('publish_date_from'));
        */
   },
    
    closeHandler: function() {
        this.trigger("close");
    }
    
    
});
