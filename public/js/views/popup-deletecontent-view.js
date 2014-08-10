var DeleteContentPopupView = PopupView.extend({
    
  render: function() {
     this.$('#deletePopUpTitle').text(this.model.get('title'));
     this.setPopupTitle('Delete content');
     this.changeTheme('danger');
     this.setApplyBTNLabel('Delete content');
     
     console.log('delete render, url:', this.model.url)
  },
  
  applyBTNHandler: function() {
      this.showLoading();
      this.model.destroy({
          error:this.contentModelDeleteEHandler,
          success:this.contentModelDeleteSHandler
      });
  },
  
  contentModelDeleteEHandler : function (model, response, options) {
       this.deleteContentPopupView.hideLoading();
  
       if (response.status==200) {
           console.log('delete status 200');
           this.deleteContentPopupView.showSuccess('Changes applied succesfully');
          /* this.deleteContentPopupView.$el.on('hidden.bs.modal', function() {
               this.deleteContentPopupView.trigger('contentDeleted',this.deleteContentPopupView.model);               
           });*/
       }else{
           console.log('delete error');
           this.deleteContentPopupView.showError('Error deleting content');
       }
       
       
   },
        
   contentModelDeleteSHandler: function (model, response, options) {
      
       this.deleteContentPopupView.hideLoading();
       this.deleteContentPopupView.showError('Error deleting content');
   }
   
});
