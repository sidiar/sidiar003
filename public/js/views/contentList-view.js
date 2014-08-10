var ContentListView = Backbone.View.extend({
    
   events: {
       "click #searchButton": "doTextSearch",
       "keypress #searchInput": "searchInputKeypressHandler",
       "click #sectionDropDown li a": "sectionFilterHandler",
       "click .editContentButton": "editContentHandler",
       "click .newContentButton": "newContentHandler",
       "click .deleteContentButton": "deleteContentHandler",       
       "click .showPublishOptionsButton": "showPublishOptionsHandler"
   },
   
   
   /*   FILTROS   */
   
   doTextSearch: function() {
       this.model.contentSearchModel.set( {
              textSearch : $('#searchInput').val() 
       });
       this.trigger("doSearch",this.model.contentSearchModel.getActionParams());
   },
   
   searchInputKeypressHandler: function(event) {
       if ( event.which == 13 ) {
            this.doTextSearch();
        }
   },
   
   sectionFilterHandler: function(event) {
       this.model.contentSearchModel.set( {
              selectedSection : $(event.target).data('value')
       });
        this.trigger("doSearch",this.model.contentSearchModel.getActionParams());
   },
       
       
       
   /*   PUBLISH OPTIONS   */
    
   showPublishOptionsHandler: function(event) {
      var contentId = $(event.target).closest('tr').data('value');
      var content = this.model.contentCollection.get(contentId);

      this.trigger("showPublishOptions",content);
      
   },
   
   statusChange: function(model) {
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
        
   },
   
        
   
   /*   OPTIONS   */
   
   editContentHandler: function(event) {
      var contentId = $(event.target).closest('tr').data('value');
      var content = this.model.contentCollection.get(contentId);

      this.trigger("editContent",content);
      
      
       //var urltoload = '/' + currentController + '/edit/id/' + $(event.target).closest('tr').data('value');
    //   var urltoload = '/status/edit/id/' + $(event.target).closest('tr').data('value');
       
    // event   mainView.loadDynamicContentTMP(urltoload);
   },
   
   
   newContentHandler: function() {

      this.trigger("newContent");
      
   },
   
   deleteContentHandler: function() {
      var contentId = $(event.target).closest('tr').data('value');
      var content = this.model.contentCollection.get(contentId);

      this.trigger("deleteContent",content);
      
   },
   
   
   
   
   
});