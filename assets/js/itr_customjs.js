   jQuery(".entry-content").append('<div id="processingdiv" class="processing"><div class="processingdiv"></div></div>'); 

      let ajax_url = ajax_object.ajax_url;

      function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
          return false;
        } else {
          return true;
        }

      }



      /*==== Shipping Address checkbox =======*/   

      $('#shaddress').prop('disabled',true);
      $('#shcity').prop('disabled',true);
      $('#shstate').prop('disabled',true);
      $('#shpostalcode').prop('disabled',true);
      $('#shcountry').prop('disabled',true);

      $('#ongoing').change(function() {

        if(this.checked) {
          $('#shaddress').prop('disabled',true);
          $('#shcity').prop('disabled',true);
          $('#shstate').prop('disabled',true);
          $('#shpostalcode').prop('disabled',true);
          $('#shcountry').prop('disabled',true);


        } else {
          $('#shaddress').prop('disabled',false);
          $('#shcity').prop('disabled',false);
          $('#shstate').prop('disabled',false);
          $('#shpostalcode').prop('disabled',false);
          $('#shcountry').prop('disabled',false);
        }
      });


      /*==== Shipping Address to billing Address Copy =======*/ 

      $(document).ready(function() {
        $("#processingdiv").css({'visibility':'hidden'});

        $('#baddress').keyup(function() {
          var address = $(this).val(); 
          $('#shaddress').val(address);
        });

        $('#bcity').keyup(function() {
          var city = $(this).val(); 
          $('#shcity').val(city);
        });

        $('#bstate').keyup(function() {
          var bstate = $(this).val(); 
          $('#shstate').val(bstate);
        });

        $('#bpostalcode').keyup(function() {
          var zipcode = $(this).val(); 
          $('#shpostalcode').val(zipcode);
        });

        $('#bcountry').keyup(function() {
          var country = $(this).val(); 
          $('#shcountry').val(country);
        });
      });




      /*==== Customer Insert =======*/   

      jQuery(document).on('click', '#customer', function () { 

        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var company = document.getElementById('company').value; 
        var email = document.getElementById('email').value; 

        var phonenumber= document.getElementById('phonenumber').value; 
        var mobilenumber = document.getElementById('mobilenumber').value; 
        var website= document.getElementById('website').value; 
        var baddress = document.getElementById('baddress').value; 
        var bcity = document.getElementById('bcity').value; 
        var bstate= document.getElementById('bstate').value; 
        var bpostalcode= document.getElementById('bpostalcode').value; 
        var bcountry= document.getElementById('bcountry').value;
        var shaddress= document.getElementById('shaddress').value; 
        var shcity = document.getElementById('shcity').value;
        var shstate= document.getElementById('shstate').value;
        var shpostalcode = document.getElementById('shpostalcode').value;
        var shcountry= document.getElementById('shcountry').value;
        var bnotes= document.getElementById('bnotes').value;
        var taxinfo= document.getElementById('taxinfo').value;
       /* var payment= document.getElementById('payment').value;
        var dmethod= document.getElementById('dmethod').value;
        var duerecipt= document.getElementById('duerecipt').value;
        var balance= document.getElementById('balance').value;
        var cdate= document.getElementById('cdate').value;*/



        if (firstname == '' || lastname == '' || company == '' || email == '' || phonenumber == '' || mobilenumber == '' 
          || baddress == '' || bcity == ''||  bstate == ''|| bpostalcode == ''|| bcountry == ''|| shaddress == ''|| shcity == '' 
          || shpostalcode =='' || shstate == ''||  shcountry == '' || taxinfo == '') { 

          jQuery('#valida_error_message').text('*All above Fields are Required');

      }else {  


        jQuery.ajax({
          url: ajax_url,
          type: "POST",
          cache: false,
          data: {
            'action':'new_db_customer',

            'firstname' : firstname,
            'lastname' : lastname,
            'company' : company,
            'email' : email,
            'phonenumber' : phonenumber,
            'mobilenumber' : mobilenumber,
            'website' : website,
            'baddress' : baddress,
            'bcity' : bcity,
            'bstate' : bstate,
            'bpostalcode' : bpostalcode,
            'bcountry' : bcountry,
            'shaddress' : shaddress,
            'shcity' : shcity,
            'shstate' : shstate,
            'shpostalcode' : shpostalcode,
            'shcountry' : shcountry,
            'bnotes' : bnotes,
            'taxinfo' :taxinfo
            /*'payment' : payment, 
            'dmethod' : dmethod,
            'duerecipt' : duerecipt,
            'balance' : balance,
            'cdate'  : cdate*/

               //23

          },
          beforeSend:function(){
           jQuery('#valida_error_message').text('');
           $(".entry-content #processingdiv").css({'visibility':'visible'});
          },

          success:function(data) {
            show_customer_estimate();
            itr_customer_list_show();
            jQuery('body #message').html('New Customer Successfully');
            if(data=='New Customer Successfully'){
             
             jQuery('#message').text(data.message);   
             jQuery("form").trigger("reset");

           }else{
            jQuery('#survey_error_message').text(data);
            jQuery("form").trigger("reset");
          }

        },
        error: function(errorThrown){
          console.log(errorThrown);
        },
        complete: function(){
        setTimeout(function() {
          $("#processingdiv").css({'visibility':'hidden'});
        }, 1000);
      }

      });  

      }

    });  




  
   /*==== Customer list show  =======*/ 
     function itr_customer_list_show(){

       jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_list_show_customer' 
          },
         /* beforeSend:function(){
          jQuery('#list_show').html('');

          },*/
         success: function(data) {

          var listcustomer =''; 
         jQuery.each(data,function(i,n){

      listcustomer += '<tr>'+     
        '<td>'+n.firstname+' '+n.lastname+ '</td>'+
        '<td>'+n.company+'</td>'+
        '<td>'+n.phonenumber +'</td>'+
        '<td>'+n.email +'</td>'+
        /*'<td>'+n.baddress +' '+n.bstate+' '+n.bcity+' '+n.bpostalcode+'</td>'+*/
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

    }); 


    /*==== Customer Delete =======*/   

    jQuery(document).on('click', '#custdel', function() {

     var id = $(this).data('id');
     var confirmMessage = 'Are you sure you want to delete this Customer Information?';
     if (confirm(confirmMessage)) {
      jQuery.ajax({
        type: 'POST',
        url: ajax_url, 
       
        data: {
          action: 'itr_delete_customer_data', 
          id: id 
        },
        success: function(response) {
          //console.log('333');
          itr_customer_list_show();
          jQuery('body #delmessage').html('Customer Deleted successfully')
          console.log('Customer deleted successfully');
        },
        error: function(xhr, status, error) {
          console.log('Error deleting data: ' + error);
        }
      });
      }
    });



      /*==== Customer name show in Estimate =======*/  

      function show_customer_estimate(){

       jQuery.ajax({
        url: ajax_url, 
        type: 'GET',
        dataType: 'json',
        cache: false,
        data: {
          action: 'itr_customer_list_show' 
        },
        beforeSend:function(){
           jQuery("#itr_customer").html('');
           var custlist = jQuery("<option>").val('').text('--Select--');
          jQuery("#itr_customer").append(custlist);
        },
        success: function(data) {
           //console.log('2eee');
         jQuery.each(data, function(index, item) {
          var custlist = jQuery("<option>").val(item.id).text(item.firstname +'  '+ item.lastname);
          jQuery("#itr_customer").append(custlist);
            //console.log('222');

        });
       },

       error: function(jqXHR, textStatus, errorThrown) {
        console.error(errorThrown);
      }

    }); 

     } 
      jQuery(document).ready(function() {

       show_customer_estimate();

      });     

      /*==== Create Estimate Number =======*/

      jQuery(document).on('click', '#itr_invoice', function () {      
        jQuery.ajax({
          url: ajax_url,
          type: "POST",
          dataType: 'json',
          cache: false,
          data: {
            action: 'estimate_number_generte'
          },
          success: function(data) {
           jQuery('#estmateno').val(data);
           jQuery('body #estimate').html('Estimate Number Create');
         } 

       });   
     });



        /*==== Create Estimate =======*/  

      jQuery(document).on('click', '#addestimate', function () { 

        var estmateno = document.getElementById('estmateno').value;
        var itr_customer = document.getElementById('itr_customer').value;
        var cemail = document.getElementById('cemail').value;
        //var itrestimate = document.getElementById('itrestimate').value;
        var itrstatusby = document.getElementById('itrstatusby').value;
        var itrstatusdate = document.getElementById('itrstatusdate').value;
        var caddress = document.getElementById('caddress').value;
        var bdate = document.getElementById('bdate').value;
        var epdate = document.getElementById('epdate').value;

        var sub_total = document.getElementById('sub_total').value;
        var itr_est_message = document.getElementById('itr_est_message').value;
        var itr_state_message = document.getElementById('itr_state_message').value;   

        var detaillist = [];

        $('.griditems').each(function () {

          var iindex = $(this).attr('itemindex');
          var product = $("#product"+iindex).val();
          var itr_customer = $("#itr_customer").val();
          var estmateno = $("#estmateno").val();
          var description = $("#description"+iindex).val();
          var qty = $("#qty"+iindex).val();
          var price = $("#price"+iindex).val();
          var total = $("#total"+iindex).val();

          detaillist.push({
            'product': product,
            'itr_customer' : itr_customer,
            'estmateno'  : estmateno,
            'description': description,
            'qty'  : qty,
            'price' : price,
            'total' : total,

          });
        });

        var dlist = detaillist;



      if (estmateno == '' || itr_customer == '' || cemail == '' || 
          itr_est_message == '' || itr_state_message == '' ) 
       { 
         jQuery('#error_message').text('*All above Fields are Required');

      }else { 
       
        console.log(333);
        jQuery.ajax({
          url: ajax_url,
          type: "POST",
          cache: false,
          data: {

            'action':'new_db_estimate_info', 
            "dlist": dlist, 

            'estmateno' : estmateno,
            'itr_customer' : itr_customer,
            'cemail' : cemail,
           // 'itrestimate' : itrestimate,
            'itrstatusby' : itrstatusby,
            'itrstatusdate' : itrstatusdate,
            'caddress' : caddress,
            'bdate' : bdate,
            'epdate' : epdate,

            'sub_total' : sub_total,
            'itr_est_message' : itr_est_message,
            'itr_state_message' : itr_state_message
          },

          beforeSend:function(){
           jQuery('#error_message').text('');
             $(".entry-content #processingdiv").css({'visibility':'visible'});
          },

          success:function(data) {
            console.log(data);
            customer_list_show_invoice();
            total_estimate_amount();
            itr_estimate_list_show();
            jQuery('body #emessage').html('Estimate Create successfully');
            if(data=='Estimate Create successfully'){
             jQuery('#emessage').text(data.emessage);   
             jQuery("form").trigger("reset");

           }else{
            jQuery('#survey_error_message').text(data);
            jQuery("form").trigger("reset");
          }

        },
        complete: function(){
        setTimeout(function() {
          $("#processingdiv").css({'visibility':'hidden'});
        }, 7000);
      },
        error: function(errorThrown){
          console.log(errorThrown);
        }

       });

       }
    });



      /* ======  Total Estimate Amount  ====== */


      function total_estimate_amount(){
        jQuery.ajax({
          url: ajaxurl, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_estimate_total_amount' 
          },
         success: function(data) {
            var payrec = parseFloat(data)
            jQuery("#estimate_total").text('$' + payrec.toFixed(2));
         },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      }); 
     }   


    jQuery(document).ready(function() {
           total_estimate_amount();
    }); 




     /*==== Estimate list show  =======*/ 

     function itr_estimate_list_show(){

       jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_estimate_customer_list' 
          },
         success: function(data) {

        var estimatelist =''; 
         jQuery.each(data,function(i,n){

      estimatelist += '<tr>'+     
        '<td>'+n.firstname+' '+n.lastname+ '</td>'+
        '<td>'+n.itr_estimate_nbr+'</td>'+
        '<td>'+n.itr_estimate_date +'</td>'+
        '<td>'+n.itr_expiration_date +'</td>'+
        '<td>'+n.itr_estimate_total+'</td>'+
        '</tr>'
           }) 
           jQuery('#estimate_list').html(estimatelist);

        },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      });

    }

    jQuery(document).ready(function() {
          
          itr_estimate_list_show();

    }); 




      /*==== Estimate status Drop down list Show =======*/  


      jQuery(document).ready(function() {
        jQuery('#itrestimate').change(function() {
          if (jQuery(this).val() == 'Pending') {
            jQuery('#itrpending').show();
          } else {
            jQuery('#itrpending').hide();
          }

          if (jQuery(this).val() == 'Accepted') {
            jQuery('#itraccept').show();
          } else {
            jQuery('#itraccept').hide();
          }

          if (jQuery(this).val() == 'Closed') {
            jQuery('#itrclose').show();
          } else {
            jQuery('#itrclose').hide();
          }

          if (jQuery(this).val() == 'Rejected') {
            jQuery('#itrrejected').show();
          } else {
            jQuery('#itrrejected').hide();
          }


        });
      });


      jQuery('#itr_customer').on('change', function() {

        var cid = jQuery(this).find(":selected").val();

        jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_estimate_display_custinfo',
            cid: cid,  
          },
          success: function(invdata) {
              //invdata = invdata[0];
            jQuery('#caddress').val(invdata.baddress);
            jQuery('#cemail').val(invdata.email);
          },
          error: function() {
            alert('Error loading content.');
          }
        });
      });




       /*==== Customer name show in Invoice =======*/  

      function customer_list_show_invoice(){

        jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'customer_listshow_invoice' 
          },
          beforeSend:function(){
            jQuery("#itr_inv_customer").html('');
            var custlist = jQuery("<option>").val('').text('--Select--');
            jQuery("#itr_inv_customer").append(custlist);
         },
          success: function(data) {
     
           jQuery.each(data, function(index, item) {
            var custlist = jQuery("<option>").val(item.id).text(item.firstname +'  '+ item.lastname);
            jQuery("#itr_inv_customer").append(custlist);
            //console.log('222');

          });
         },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }

      }); 


      }  

      jQuery(document).ready(function() {
        customer_list_show_invoice();
      });  




       /*===== Customer name and info Show  =======*/  


      jQuery('#itr_inv_customer').on('change', function() {

        var cstid = jQuery(this).find(":selected").val();
        if (cstid == ''){
          jQuery('.invtbody').html('');
          jQuery('#result').html('');
          jQuery('#itrinvaddress').val('');
          jQuery('#itrinvemail').val('');
          jQuery('#itr_invesdate').val('');
          jQuery('#itr_invepdate').val('');
          jQuery('#itrinvterms').html('');
        }  

        jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_invoice_display',
            cstid: cstid,  
          },
          success: function(invdata) {
            jQuery('#result').empty();
            jQuery.each(invdata,function(i,n){ 
              jQuery('#result').append('<a href="#">'+n.itr_estimate_inv_nbr+'</a>'+ 
                '<input type="hidden" value="'+n.itr_estimate_inv_nbr+'" id="itr_inv_estimate_number" name="itr_inv_estimate_number">'
                +'<br>' );

            });   

            jQuery('#itrinvaddress').val(invdata[0].itr_estimate_address);
            jQuery('#itrinvemail').val(invdata[0].itr_customer_email);
    
          },
          error: function() {
            alert('Error loading content.');
          }
        });
      });



     /*===== click invoice show invoice details ====== */

      jQuery(document).on('click', '#result a', function () {  

          //console.log(jQuery(this).text());

        var invsub_total = 0.00;
        var invid = jQuery(this).text();

        jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_allinvoice_show',
            invid: invid,  
          },
          success: function(data) {

            var empty ='';
            jQuery.each(data,function(i,n){
              empty += '<tr id="itrinvaddr'+i+'" class="invgriditems" invitemindex="'+i+'">' +
              '<td> <input type="hidden" name="inv_custid" id="inv_custid" value="'+n.customer_id+'"/>'+ 
              '<input type="hidden" name="inv_esti_number" id="inv_esti_number" value="'+n.itr_estimate_nbr+'"/>'+  
              '<input type="text" name="invproduct[]" id="invproduct'+i+'" value="'+n.itr_pro_name+'" placeholder="Enter Product Name" class="form-control"/></td>'+
              '<td><input type="text" name="invdescription[]" id="invdescription'+i+'" value="'+n.itr_description+'" placeholder="Enter Description Name" class="form-control"/></td>'+
              '<td><input type="text" name="invqty[]" onkeypress="return isNumberKey(event)" id="invqty'+i+'" value="'+n.itr_qtn+'" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>'+
              '<td><input type="text" name="invprice[]" onkeypress="return isNumberKey(event)" id="invprice'+i+'"  value="'+n.itr_rate+'" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/></td>'+
              '<td><input type="text" name="invtotal[]" id="invtotal'+i+'"  value="'+n.itr_rate_total+'" placeholder="0.00" class="form-control total"/></td>'+
              '</tr>';
              invsub_total = parseFloat(invsub_total) + parseFloat(n.itr_rate_total);         
            })

            jQuery('#invsub_total').val(invsub_total);
            jQuery('.invtbody').html(empty);

            /*jQuery('#itr_invesdate').val(invdata[0].itr_estimate_date);
            jQuery('#itr_invepdate').val(invdata[0].itr_expiration_date);*/

          } 

        });   

      });

   
     /*===== click invoice show invoice Estimate date and Expair date ====== */

     
     jQuery(document).on('click', '#result a', function () {  

        var invid = jQuery(this).text();

        jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_click_invoice_showdate',
            invid: invid,  
          },
          success: function(data) {
            console.log(data);

            jQuery('#itr_invesdate').val(data.itr_estimate_date);
            jQuery('#itr_invepdate').val(data.itr_expiration_date);

          } 

        });   

      });



     

      /* ======= Create invoice code ===== */ 


      jQuery(document).on('click', '#addInvoice', function () { 

        //console.log(111);

        var inv_esti_number = document.getElementById('inv_esti_number').value;
        var itr_inv_customer = document.getElementById('itr_inv_customer').value;
        var itrinvemail = document.getElementById('itrinvemail').value;
        var itrinvaddress = document.getElementById('itrinvaddress').value;
         /*var itrinvterms = document.getElementById('itrinvterms').value;*/
        var itr_invesdate = document.getElementById('itr_invesdate').value;
        var itr_invepdate = document.getElementById('itr_invepdate').value;
        

        var invsub_total = document.getElementById('invsub_total').value;
        var itr_invoice_message = document.getElementById('itr_invoice_message').value;
        var itr_inv_statement_message = document.getElementById('itr_inv_statement_message').value;   


        var invoiclist = [];

        $('.invgriditems').each(function () {

          var index = $(this).attr('invitemindex');
          var invproduct = $("#invproduct"+index).val();
          var inv_custid = $("#inv_custid").val();
          var inv_esti_number = $("#inv_esti_number").val();
          var invdescription = $("#invdescription"+index).val();
          var invqty = $("#invqty"+index).val();
          var invprice = $("#invprice"+index).val();
          var invtotal = $("#invtotal"+index).val();

          invoiclist.push({
            'invproduct': invproduct,
            'inv_custid' : inv_custid,
            'inv_esti_number' : inv_esti_number,
            'invdescription': invdescription,
            'invqty'  : invqty,
            'invprice' : invprice,
            'invtotal' : invtotal,

          });
        });

     var invlist = invoiclist;

    if (itr_inv_customer == '' || itrinvemail == '' || itrinvaddress == '' || 
      invsub_total == '' || itr_invoice_message == '' || itr_inv_statement_message == '' ) 
     { 
          jQuery('#invalid_message').text('*All above Fields are Required');

      }else { 

        console.log(333);
        jQuery.ajax({
          url: ajax_url,
          type: "POST",
          cache: false,
          data: {

            'action':'itr_db_invoice_info', 
            "invlist": invlist, 

            'inv_esti_number' : inv_esti_number,
            'itr_inv_customer' : itr_inv_customer,
            'itrinvemail' : itrinvemail,
            'itrinvaddress' : itrinvaddress,
            'itr_invesdate' : itr_invesdate,
            'itr_invepdate' : itr_invepdate,

            'invsub_total' : invsub_total,
            'itr_invoice_message' : itr_invoice_message,
            'itr_inv_statement_message' : itr_inv_statement_message
          },

          beforeSend:function(){
           jQuery('#invalid_message').text('');
           $(".entry-content #processingdiv").css({'visibility':'visible'});
          },

          success:function(data) {
            console.log(data);
            itr_recieve_payment_customer_list();
            itr_invoice_list_show();   
            itr_over_due_payment_list_show(); // over due payment report
            jQuery('body #imessage').html('Invoice Create Successfully');
            if(data=='Invoice Create Successfully'){
             jQuery('#imessage').text(data.imessage);   
             jQuery("form").trigger("reset");

             /* jQuery('body #emessage').html('Estimate Create successfully');
            if(data=='Estimate Create successfully'){
             jQuery('#emessage').text(data.emessage);   
             jQuery("form").trigger("reset");*/

           }else{
            jQuery('#survey_error_message').text(data);
            jQuery("form").trigger("reset");
          }

        },
         complete: function(){
        setTimeout(function() {
          $("#processingdiv").css({'visibility':'hidden'});
        }, 7000);
      },
        error: function(errorThrown){
          console.log(errorThrown);
        }
      });

      }
    });
  
      
    /*===== Invoice Customer list show ======= */

      function itr_invoice_list_show(){

       jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_invoice_customer_list' 
          },
         success: function(data) {

        var invlist =''; 
         jQuery.each(data,function(i,n){

        invlist += '<tr>'+     
        '<td>'+n.firstname+' '+n.lastname+ '</td>'+
        '<td>'+n.itr_invoice_nbr+'</td>'+
        '<td>'+n.itr_inv_estimate_date +'</td>'+
        '<td>'+n.itr_inv_expiration_date +'</td>'+
        '<td>'+n.itr_invoice_total+'</td>'+
        '</tr>'
           }) 
          jQuery('#customer_invoice_list').html(invlist);

        },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      });

    }

    jQuery(document).ready(function() {
          itr_invoice_list_show();
    }); 



    /*====== Customer list show in Payment Recieve section ======= */    
     
      function itr_recieve_payment_customer_list(){
        jQuery.ajax ({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_customer_payment_recieve' 
          },

          beforeSend:function(){
            jQuery("#itr_pay_customer").html('');
            var custlist = jQuery("<option>").val('').text('--Select--');
            jQuery("#itr_pay_customer").append(custlist);
         },

          success: function(data) {
            console.log(data);
           jQuery('#invo_id').empty();
           jQuery.each(data, function(index, item) {
            var custlist = jQuery("<option>").val(item.id).text(item.firstname +'  '+ item.lastname);
            jQuery("#itr_pay_customer").append(custlist);

          });

           //jQuery("#itr_payemail").val(data.email); 

         },
         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      }); 
      }

      jQuery(document).ready(function() {

       itr_recieve_payment_customer_list();
    
    });  


   /* ===== Payment Recive ====== */


      jQuery('#itr_pay_customer').on('change', function() {

        var cstid = jQuery(this).find(":selected").val();
        if (cstid == ''){
          jQuery('#invo_id').html('');
          jQuery('#itr_payemail').val('');
          jQuery('#itr_paydate').val('');

          jQuery('#desc').html('');
          jQuery('#due_date').html('');
          jQuery('#orginal_amount').html('');
          jQuery('#open_balance').html('');
          jQuery('#due_balance').html('');
          

          jQuery("#itr_payment_amount").hide();
          jQuery("#itr_apply_amt").hide();
          jQuery("#recive_payment_amount").hide();
          
        }

        jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_payeble_display',
            cstid: cstid,  
          },
          success: function(invdata) { 
            jQuery('#invo_id').empty();
            jQuery.each(invdata,function(i,n){ 
            jQuery('#invo_id').append('<a href="#">'+n.itr_invoice_nbr+'</a>'+ 
              /*'<input type="hidden" id="payment_nrb_recive" name="payment_nrb_recive" value="'+n.itr_invoice_nbr+'">'
                +*/'</br>' );
            });   

            jQuery('#itr_payemail').val(invdata[0].itr_inv_customer_email);
            //jQuery('#itr_paydate').val(invdata[0].itr_inv_estimate_date);
            //jQuery('#itr_paydate').val(invdata[0].itr_inv_expiration_date);

          },
          error: function() {
            alert('Error loading content.');
          }
        });
      });


      /* ===== Click Invoice show all data in payment recive ====== */  

      jQuery(document).on('click', '#invo_id a', function () {  
        var invo = jQuery(this).text();

        if (invo === ''){}

        jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_subtotal_show',
            invo: invo,  
          },
          success: function(data) {

            jQuery('#desc').append("Invoice No :" +data.itr_invoice_nbr);
            jQuery('#payment_nrb_recive').val(data.itr_invoice_nbr);
            jQuery('#itr_paydate').val(data.itr_inv_estimate_date);
            jQuery('#due_date').append(data.itr_inv_expiration_date);
            jQuery('#orginal_amount').append(data.itr_invoice_total);


          } 

        });   

      });


      /* ===== Click Invoice show all data in payment recive ====== */  

      jQuery(document).on('click', '#invo_id a', function () {  

          var invoid = jQuery(this).text();
        /*  console.log('11');*/
          jQuery.ajax({
          url: ajax_url,
          type: "GET",
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_duebalance_show',
            invoid: invoid,  
          },
          success: function(data) {
            
         //console.log(data);
          jQuery('#orginal').append(data.itr_invoice_total);
          jQuery('#open_balance').append(data.totalbalance);
          
          var dueamount = data.itr_invoice_total - data.totalbalance;
          jQuery('#due_balance').text(data.itr_invoice_total - data.totalbalance); 

          } 

           });

        });
  


   /* ===== Payment Transection ====== */

      jQuery(function() {
        jQuery('#itr_apply_amt').keyup(function() {
          jQuery('#amount_apply').text(jQuery(this).val());
          jQuery('#itr_payment_reciv').val(jQuery(this).val());
        }); 
      });


    /* ===== Payment equality check ====== */

      jQuery(document).ready(function() {

       $('#itr_apply_amt').on('keypress', function(event) {
        if (event.which < 48 || event.which > 57) {
          event.preventDefault();
          $(this).val('');
        }
      });

       jQuery('#itr_apply_amt').keyup(function() { 
        var numberDiv = parseFloat($('#orginal_amount').text());
        var numberInput = parseFloat($('#itr_apply_amt').val());

        if (numberInput > numberDiv) {
          jQuery(this).val('');
          jQuery('#itr_payment_reciv').val('');
          jQuery('#amount_apply').text('0.00');
        } 
      });
     });


    /* ===== Payment Recieve section Visibility check ====== */

      jQuery(document).ready(function() {
        jQuery("#itr_payment_amount").hide();
        jQuery("#itr_apply_amt").hide();
        jQuery("#recive_payment_amount").hide();

        jQuery("#invo_id").click(function() {

        jQuery('#desc').html('');
        jQuery('#due_date').html('');
        jQuery('#orginal_amount').html('');
        jQuery('#open_balance').html('');

        jQuery("#itr_payment_amount").show();
        jQuery("#itr_apply_amt").show();
        jQuery("#recive_payment_amount").show();
        });
      });


    /* ===== Add Payment recive  ====== */


      jQuery(document).on('click', '#ClearPayment', function () { 

        var itr_pay_customer = document.getElementById('itr_pay_customer').value;
        var payment_nrb_recive = document.getElementById('payment_nrb_recive').value; 
        var itr_payment_method = document.getElementById('itr_payment_method').value;
        var itr_paydate = document.getElementById('itr_paydate').value;
        
        var itr_pay_referance = document.getElementById('itr_pay_referance').value; 
        var itr_deposit_type = document.getElementById('itr_deposit_type').value; 
        var itr_apply_amt = document.getElementById('itr_apply_amt').value; 
        var itr_pay_sms = document.getElementById('itr_pay_sms').value; 


        if (itr_pay_customer == '' || payment_nrb_recive == "" || itr_payment_method == '' || itr_pay_referance == '' || itr_deposit_type ==''  
         || itr_pay_sms == '' ) { 

          jQuery('#perror_message').text('*All above Fields are Required');

      }else {  


        jQuery.ajax({
          url: ajax_url,
          type: "POST",
          cache: false,
          data: {
            'action':'itr_payment_recive_show',

            'itr_pay_customer' : itr_pay_customer,
            'payment_nrb_recive' : payment_nrb_recive,
            'itr_paydate' : itr_paydate,
            'itr_payment_method' : itr_payment_method,
            'itr_pay_referance' : itr_pay_referance,
            'itr_deposit_type' : itr_deposit_type,
            'itr_apply_amt' : itr_apply_amt,
            'itr_pay_sms'  : itr_pay_sms,


          },
          beforeSend:function(){
            jQuery('#perror_message').text('');
            $(".entry-content #processingdiv").css({'visibility':'visible'});
         },

          success:function(data) {
            //console.log('ddddd');
            itr_payment_recive_list_show();  // recive list report
            itr_over_due_payment_list_show(); // over due payment report

            jQuery('#pmessage').text('Payment Received Successfully');
            jQuery("form").trigger("reset");
            if(data =='Payment Received Successfully'){
             jQuery('#pmessage').text(data.message);   
             jQuery("form").trigger("reset");

           }else{
            jQuery('#survey_error_message').text(data);
            jQuery("form").trigger("reset");
          }

        },
         complete: function(){
        setTimeout(function() {
          $("#processingdiv").css({'visibility':'hidden'});
        }, 7000);
      },
        error: function(errorThrown){
          console.log(errorThrown);
        }
       });  
      }

    });  


     /*===== Payment Recieve List ======= */

      function itr_payment_recive_list_show(){

       jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_payment_recive_list' 
          },
         success: function(data) {

        var paylist =''; 
         jQuery.each(data,function(i,n){

        paylist += '<tr>'+     
        '<td>'+n.firstname+' '+n.lastname+ '</td>'+
        '<td>'+n.itr_pay_invoice_nbr+'</td>'+
        '<td>'+n.itr_payment_method +'</td>'+
        '<td>'+n.itr_pay_deposit_to +'</td>'+
        '<td>'+n.itr_total_payment_receive+'</td>'+
        '<td>'+n.itr_pay_recive_date+'</td>'+
        '</tr>'
           }) 
          jQuery('#customer_payment_list').html(paylist);

        },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      });

    }

    jQuery(document).ready(function() {
          itr_payment_recive_list_show();
    });  



    /*===== Over due payment list ======= */

      function itr_over_due_payment_list_show(){

       jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_overdue_report' 
          },
         success: function(data) {

        var duepaylist =''; 
         jQuery.each(data,function(i,n){

        duepaylist += '<tr>'+     
        '<td>'+n.firstname+' '+n.lastname+ '</td>'+
        '<td>'+n.itr_invoice_nbr+'</td>'+
        '<td>'+n.itr_invoice_total +'</td>'+
        '<td>'+n.itr_inv_expiration_date +'</td>'+
        '</tr>'
           }) 
          jQuery('#over_due_list').html(duepaylist);

        },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }
      });

    }

    jQuery(document).ready(function() {
          itr_over_due_payment_list_show();
    });

  


    /* ======  numeric data check ====== */

      function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
      }


     /* ======  Total Payment Recieve show in dashboard  ====== */
      
      jQuery(document).ready(function() {

        jQuery.ajax({
          url: ajax_url, 
          type: 'GET',
          dataType: 'json',
          cache: false,
          data: {
            action: 'itr_total_payment_recieve' 
          },
          success: function(data) {
            var payrec = parseFloat(data)
            jQuery("#total_recieve").text('$' + payrec.toFixed(2));
         },

         error: function(jqXHR, textStatus, errorThrown) {
          console.error(errorThrown);
        }

      }); 

    }); 



