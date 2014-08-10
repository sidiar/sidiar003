var PopupView = Backbone.View.extend({
   
   originalEvents: {
     "click ._popup_apply_btn" : "applyBTNHandler",
     "click ._popup_success_btn" : "successBTNHandler"
     
   },
   //Override this event hash in
   //a child view
   childEvents: {
   },
   
   events : function() {
      return _.extend({},this.originalEvents,this.childEvents);
   },
   
   initialize: function() {
       this.$('._popup_success_messagebox').hide();
       this.$('._popup_loading_messagebox').hide();
       this.$('._popup_error_messagebox').hide();
       this.$('._popup_bodybox').show();
       console.log('render',this);
       this.render();
   },
   
    
   showPopup: function() {
       this.$el.modal('show');
   },
   
   closePopup: function() {
       this.$el.modal('hide');
   },
   
   successBTNHandler: function() {
        console.log("successBTNHandler");
        //this.$el.on('hidden.bs.modal', this.successHiddenHandler(this));
        this.$el.on('hide', this.successHiddenHandler(this));
        this.closePopup();
   },
   
   successHiddenHandler: function(view) {
     console.log('successHiddenHandler',view);
     view.trigger('success', view.model); 
   },
   
   showContent: function() {
       this.$('._popup_bodybox').show();
   },
   
   hideContent: function() {
       this.$('._popup_bodybox').hide();
   },
   
   
   showLoading: function () {
       this.hideContent();
       this.$('._popup_loading_messagebox').show();
   },
   
   hideLoading: function () {
       this.$('._popup_loading_messagebox').hide();
   },
   
   
   showSuccess: function (message) {
      this.$('._popup_success_message').text(message);
      this.$('._popup_success_messagebox').show();
      
   },
   
   showError: function (message) {
      this.showContent();
      this.$('._popup_error_messagebox').text(message);
      this.$('._popup_error_messagebox').show();
   },

   setPopupTitle: function(thetitle) {
     this.$('._popup_title').text(thetitle);
   },
 
   changeTheme: function(theme_name) {
     this.$('.panel-heading').removeClass('heading-success');
     this.$('.panel-heading').addClass('heading-' + theme_name);
     this.$('.panel-popup').removeClass('border-success');
     this.$('.panel-popup').addClass('border-'+theme_name);
   },
   
   setApplyBTNLabel: function(thelabel) {
     this.$('._popup_apply_btn').text(thelabel);
   },
           
     

});
