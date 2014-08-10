var PublishContentPopupView = PopupView.extend({

  childEvents: {
       "change #optionStatusPending,#optionStatusOn,#optionStatusOff" : "showDateFrom",
       "change #optionStatusUntil": "showDateTo"
   },
   
  render: function() {
      
       /* title */
       this.setPopupTitle('Publish options: "' + this.model.getShortTitle() + '"');
       
       /* dates */ 
       this.$('#inputDateFrom').val(this.model.get('publish_date_from'));
       this.$('#inputDateTo').val(this.model.get('publish_date_to'));
       
       this.uncheckAllStatus();
       this.checkSelectedStatus();
       
       
       if (this.model.get('expires')=='1') {
            this.$("input[name='optionStatusUntil']").prop("checked","on");
       }else{
            this.$("input[name='optionStatusUntil']").prop("checked","");
       }
       
       this.showDateFrom();
       this.showDateTo();
  
       this.$('#inputDateFromContainer').removeClass('has-error');
       this.$('#inputDateToContainer').removeClass('has-error');
       
  },
  
  
   uncheckAllStatus: function () {
       this.$('.btn-change-status-on, .btn-change-status-off, .btn-change-status-pending').removeClass('active');
       this.$('#optionStatusOn, #optionStatusOff, #optionStatusPending').prop('checked',false);
   },
   
   checkSelectedStatus: function () {
       
        switch (this.model.get('status')) {
            case '0':
                this.$('.btn-change-status-off').addClass('active');
                this.$('#optionStatusOff').prop('checked',true);
                break;
            case '1':
                this.$('.btn-change-status-on').addClass('active');
                this.$('#optionStatusOn').prop('checked',true);
                break;
            case '2':
                this.$('.btn-change-status-pending').addClass('active');
                this.$('#optionStatusPending').prop('checked',true);
                break;
           
        }
   },
   
   showDateFrom: function () {
       if (this.$("input[name='optionStatus']:checked").val()=='2') {
          this.$('#inputDateFromContainer').show();
       }else{
          this.$('#inputDateFromContainer').hide();
       }
   },
   
   showDateTo: function () {
       if (this.$("input[name='optionStatusUntil']:checked").val()==='on') {
           this.$('#inputDateToContainer').show();
       }else{
           this.$('#inputDateToContainer').hide();
           this.$('#inputDateTo').val(null);
       }
   },
   
   formatDate:  function (dateString) {
        return dateString.replace("/", "-"); 
   },
    
  applyBTNHandler: function() {      
      this.showLoading();       
      this.model.save(
       {
           status:                  this.$("input[name='optionStatus']:checked").val(),
           publish_date_from:       this.formatDate(this.$('#inputDateFrom').val()),
           expires:   this.$("input[name='optionStatusUntil']:checked").val()==='on',
           publish_date_to:         this.formatDate(this.$('#inputDateTo').val())
       },{
          error:this.contentModelSaveEHandler,
          success:this.contentModelSaveSHandler
      });
  },
  
   /*
    * VALID Error Handler
    */
   
   statusModelValidErrorHandler: function (error) {
       this.hideLoading();
       
       switch (error) {
                
            case "INVALID_DATE_FROM":
                this.$('#inputDateFromContainer').addClass('has-error');
                this.showError('Date from must be a valid date');
                break;
             
             case "DATE_FROM_OLD":
                this.$('#inputDateFromContainer').addClass('has-error');
                this.showError('Date from must be following today');
                break;
                
            case "INVALID_DATE_TO":
                this.$('#inputDateToContainer').addClass('has-error');
                this.showError('Expiration date must be a valid date');
                break;
             
             case "DATE_TO_OLD":
                this.$('#inputDateToContainer').addClass('has-error');
                this.showError('Expiration date must be following today');
                break;           
                
             case "DATE_TO_OLDER_THAN_FROM":                   
                this.$('#inputDateToContainer').addClass('has-error');
                this.showError('Expiration date must be following publish date');
                break;           
                
       }
   },
   
   
  contentModelSaveEHandler : function (model, response, options) {
      console.log('contentModelDeleteEHandler');
       this.publishContentPopupView.hideLoading();
      
       if (response.status==200) {
           console.log('delete status 200');
           this.publishContentPopupView.showSuccess('Changes applied succesfully');
          /* this.deleteContentPopupView.$el.on('hidden.bs.modal', function() {
               this.deleteContentPopupView.trigger('contentDeleted',this.deleteContentPopupView.model);               
           });*/
       }else{
           console.log('delete error');
           this.publishContentPopupView.showError('Error saving new content');
       }
       
       
   },
        
   contentModelSaveSHandler: function (model, response, options) {
      console.log('contentModelDeleteSHandler');
       this.publishContentPopupView.hideLoading();
       this.publishContentPopupView.showSuccess('Changes applied succesfully');
   }
   
});
