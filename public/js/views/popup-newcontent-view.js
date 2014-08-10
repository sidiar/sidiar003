var NewContentPopupView = PopupView.extend({
    
  render: function() {
     this.setPopupTitle(this.model.get('popuptitle'));
     
  },
  
  applyBTNHandler: function() {      
      if (this.$('#newContentTitleInput').val()) {
           this.showLoading();
           this.model.save({
                title: this.$('#newContentTitleInput').val()
            },
           {error:this.contentModelSaveEHandler,success:this.contentModelSaveSHandler} 
           );
       }
  },
  
  contentModelSaveEHandler : function (model, response, options) {
      console.log('contentModelDeleteEHandler');
       this.newContentModalView.hideLoading();
      
       if (response.status==200) {
           console.log('delete status 200');
           this.newContentModalView.showSuccess('Changes applied succesfully');
          /* this.deleteContentPopupView.$el.on('hidden.bs.modal', function() {
               this.deleteContentPopupView.trigger('contentDeleted',this.deleteContentPopupView.model);               
           });*/
       }else{
           console.log('delete error');
           this.newContentModalView.showError('Error saving new content');
       }
       
       
   },
        
   contentModelSaveSHandler: function (model, response, options) {
      console.log('contentModelDeleteSHandler');
       this.newContentModalView.hideLoading();
       this.newContentModalView.showSuccess('Changes applied succesfully');
   }
   
});
