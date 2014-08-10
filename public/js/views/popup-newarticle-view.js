var NewArticlePopupView = NewContentPopupView.extend({
    
  render: function() {
     this.setPopupTitle('New article');
     
  },
  
  applyBTNHandler: function() {      
      if (this.$('#newContentTitleInput').val()) {
           this.showLoading();
           this.model.save({
                title: this.$('#newContentTitleInput').val(),
                section_id: this.$('#newArticleSection').val()
            },
           {error:this.contentModelSaveEHandler,success:this.contentModelSaveSHandler} 
           );
       }
  },
   
});
