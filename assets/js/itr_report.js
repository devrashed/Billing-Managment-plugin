let ajaxurl = ajax_obj.ajaxurl;


    /*==== Customer List =======*/   

/*  $(document).ready(function () {
      $('#list_show').DataTable();
  });*/


  /*==== Customer section =======*/   

  jQuery(document).ready(function () {
    
        jQuery('#show_data').DataTable({
           "info":     false,
            pagingType: 'full',
            lengthMenu: [[5, 10], [5, 10]]
        });
    }); 

    

  /*==== Estimate List =======*/   

  jQuery(document).ready(function () {
    
        jQuery('#estimate_list_show').DataTable({
           "info":     false,
             pagingType: 'full',
            lengthMenu: [[5, 10], [5, 10]]
        });
    });


     /*==== invoice List =======*/   

  jQuery(document).ready(function () {
    
        jQuery('#invoice_list').DataTable({
           "info":     false,
            pagingType: 'full',
            lengthMenu: [[5, 10], [5, 10]]
        });
    });


  /*==== Recieve Payment List =======*/   

  jQuery(document).ready(function () {
    
        jQuery('#transection_data').DataTable({
           "info":     false,
             pagingType: 'full',
            lengthMenu: [[5, 10], [5, 10]]
        });
    });



/*==== Over due Payment List =======*/   

  jQuery(document).ready(function () {
    
        jQuery('#over_due_data').DataTable({
           "info":     false,
             pagingType: 'full',
            lengthMenu: [[5, 10], [5, 10]]
        });
    });
 
  

  /* ======  Total Estimate display  ====== */

    /*jQuery(document).ready(function() {
        jQuery.ajax({
          url: ajaxurl, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_estimate_list' 
          },
         success: function(data) {
            var payrec = parseFloat(data)
            jQuery("#estimate_total").text('$' + payrec.toFixed(2));
         },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      }); 
    }); */


    
 
 /* ======  Total Estimate Amount  ====== */

    jQuery(document).ready(function() {
        jQuery.ajax({
          url: ajaxurl, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_invoice_total' 
          },
         success: function(data) {
            var payrec = parseFloat(data)
            jQuery("#invoice_total").text('$' + payrec.toFixed(2));
         },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      }); 
    }); 

/*==== View cutomser data  =======*/   

  jQuery(document).on('click', '#custshow', function() {

   var id = $(this).data('id');
   console.log(id);

    jQuery.ajax({
      type: 'GET',
      url: ajaxurl,
      dataType: 'json',
      cache: false, 
      data: {
        action: 'itr_show_customer_data', 
        id: id 
      },
      success: function(data) {
      //console.log(data);
      jQuery("#ex1").html(
      //data.firstname + data.lastname,

  '<table class="table table-bordered">' +
  '<tr>'+
    '<td><b>First Name</b></td>'+
    '<td>'+data.firstname+'</td>'+
    '<td><b>Last Name</b></td>'+
    '<td>'+data.lastname+'</td>'+
    '<td><b>Email</b></td>'+
    '<td>'+data.email+'</td>'+
  '</tr>'+

  '<tr>'+
    '<td><b>Phone Number</b></td>'+
    '<td>'+data.phonenumber+'</td>'+
    '<td><b>Mobile Number</b></td>'+
    '<td>'+data.mobilenumber+'</td>'+
    '<td><b>Website</b></td>'+
    '<td>'+data.website+'</td>'+
  '</tr>'+
  
 '</table>' +

  '<h5>Billing Address</h5>'+  
   
'<table class="table table-bordered">' +
  '<tr>'+
    '<td><b>Street Address</b></td>'+
    '<td>'+data.baddress+'</td>'+
    '<td><b>City/Town</b></td>'+
    '<td>'+data.bcity+'</td>'+
  '</tr>'+

  '<tr>'+
   '<td><b>State/Province</b></td>'+
    '<td>'+data.bstate+'</td>'+
    '<td><b>Postal Code</b></td>'+
    '<td>'+data.bpostalcode+'</td>'+
  '</tr>'+

  '<tr>'+
    '<td><b>Country</b></td>'+
    '<td>'+data.bcountry+'</td>'+
  '</tr>'+
  
 '</table>'+

  '<h5>Shipping Address</h5>'+  
   
'<table class="table table-bordered">' +
  '<tr>'+
    '<td><b>Street Address</b></td>'+
    '<td>'+data.shaddress+'</td>'+
    '<td><b>City/Town</b></td>'+
    '<td>'+data.shcity+'</td>'+
  '</tr>'+

  '<tr>'+
   '<td><b>State/Province</b></td>'+
    '<td>'+data.shstate+'</td>'+
    '<td><b>Postal Code</b></td>'+
    '<td>'+data.spostalcode+'</td>'+
  '</tr>'+

  '<tr>'+
    '<td><b>Country</b></td>'+
    '<td>'+data.shcountry+'</td>'+
  '</tr>'+
  
 '</table>'+ 
  
  '<h5>Notes</h5>'+ 
  
  '<table class="table table-bordered">' +
    '<tr>'+
    '<td>'+data.bnotes+'</td>'+
  '</table>'+ 

   '<h5>Tax Info</h5>'+  

   '<table class="table table-bordered">' +
    '<tr>'+
    '<td>'+data.taxinfo+'</td>'+
  '</table>' 
   );
 },
      error: function(xhr, status, error) {
        console.log('Error deleting data: ' + error);
      }
    });
  });


  /*==== Overdue Report Generate  =======*/ 

  jQuery(document).ready(function() {
        jQuery.ajax({
          url: ajaxurl, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_overdue_report' 
          },
         success: function(data) {

          var overreport =''; 
         jQuery.each(data,function(i,n){

            overreport +='<tr>'+     
              '<td>'+n.firstname+'</td>'+
              '<td>'+n.itr_invoice_nbr+'</td>'+
              '<td>'+n.itr_invoice_total +'</td>'+
              '<td>'+n.itr_inv_expiration_date +'</td>'+
              '</tr>'
           }) 
           jQuery('#overdue').html(overreport);

        },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      }); 
    }); 

  /*==== Customer Delete =======*/   

  /*jQuery(document).on('click', '#custdel', function() {

   var id = $(this).data('id');
    console.log(id);*/
   /* var confirmMessage = 'Are you sure you want to delete this record?';
    if (confirm(confirmMessage)) {*/
    /*jQuery.ajax({
      type: 'POST',
      url: ajaxurl, 
      dataType: 'json',
      cache: false,
      data: {
        action: 'delete_customer_data', 
        id: id 
      },
      success: function(response) {
        //console.log('333');
        itr_customer_list_show();
        console.log('Data deleted successfully!');
      },
      error: function(xhr, status, error) {
        console.log('Error deleting data: ' + error);
      }
    });*/
    //}
  //});


 


    /*==== Customer list show  =======*/ 

    /*function itr_customer_list_show(){

       jQuery.ajax({
          url: ajaxurl, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_list_show_customer' 
          },
          beforeSend:function(){
          jQuery('#list_show').html('');

          },
         success: function(data) {

          var listcustomer =''; 
         jQuery.each(data,function(i,n){

      listcustomer += '<tr>'+     
        '<td>'+n.firstname+' '+n.lastname+ '</td>'+
        '<td>'+n.company+'</td>'+
        '<td>'+n.phonenumber +'</td>'+
        '<td>'+n.email +'</td>'+
        '<td>'+n.baddress +' '+n.bstate+' '+n.bcity+' '+n.bpostalcode+'</td>'+
        '<td>'+n.taxinfo +'</td>'+
        '<td>' 

        +'<a href="#ex1" rel="modal:open" id="custshow" data-id="'+n.id+'">View</a>' +
        '<button id="custdel" class="btn btn-danger" data-id="'+n.id+'">Delete</button>' 

        +'</td>'+
        '</tr>'
           }) 
           jQuery('#list_show').html(listcustomer);

        },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      });

    }

    jQuery(document).ready(function() {
          
          itr_customer_list_show();

    });*/ 

