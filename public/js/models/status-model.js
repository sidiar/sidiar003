
var StatusModel = Backbone.Model.extend({
   
   url: '/api/status',
   /*
   options: {
        success: function(data){
            console.log(data);
        },
        error: function(x, t, e){
            console.log("error: " + t + ", " + e);
        }
    },
   */
   getShortTitle: function() {
       var title = this.get("title");
       return (title.length>38) ? title.substr(0,35) + "..." : title;
   },
   
   validate: function(attrs) {
       
       
       
       /* status pending */
       
       if (attrs.status=='2') {
           
           /* is valid date */
           if (!isValidDate(attrs.publish_date_from)) {
               return "INVALID_DATE_FROM";
           }
           
           /* is later than today */ 

           today = new Date();
           selectedDateFromAsDate = new Date(attrs.publish_date_from);

           if (selectedDateFromAsDate<=today) {
               return "DATE_FROM_OLD";
           }
              
       }
       
       /* status until date */
       if (attrs.expires) {
            
             /* is valid date */ 
              if (!isValidDate(attrs.publish_date_to)) {
                  return "INVALID_DATE_TO";
              }
              
              /* is later than today */ 

             today = new Date();
             selectedDateToAsDate = new Date(attrs.publish_date_to);
              
              if (selectedDateToAsDate<=today) {
                  return "DATE_TO_OLD";
              }
              
              /* is prior than date from */ 

             selectedDateFromAsDate = new Date(attrs.publish_date_from);
              
              if (selectedDateToAsDate<=selectedDateFromAsDate) {
                  return "DATE_TO_OLDER_THAN_FROM";
              }
       
       }
       
   }
   
});


