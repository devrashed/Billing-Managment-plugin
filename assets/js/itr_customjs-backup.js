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

	var shcountry= document.getElementById('shcountry').value;
	var bnotes= document.getElementById('bnotes').value;
	var taxinfo= document.getElementById('taxinfo').value;
	var payment= document.getElementById('payment').value;
	var dmethod= document.getElementById('dmethod').value;
	var duerecipt= document.getElementById('duerecipt').value;
	var balance= document.getElementById('balance').value;
	var cdate= document.getElementById('cdate').value;



 if (firstname == '' || lastname == '' || company == '' || email == '' || phonenumber == '' || mobilenumber == '' 
 	|| baddress == '' || bcity == ''||  bstate == ''|| bpostalcode == ''|| bcountry == ''|| shaddress == ''|| shcity == '' 
 	|| shstate == ''|| shcountry == '' || taxinfo == '' || payment == '' || dmethod == '' || duerecipt == '' || 
 	balance == '' || cdate == '' ) { 

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
            'shcountry' : shcountry,
            'bnotes' : bnotes,
           	'taxinfo' :taxinfo,
           	'payment' : payment, 
           	'dmethod' : dmethod,
		    		'duerecipt' : duerecipt,
		    		'balance' : balance,
		    		'cdate'	 : cdate

    		 //23

        },
        success:function(data) {
     	  
        	  jQuery('body #message').html('Customer created successfully');
            if(data=='Message sent successfully'){
               jQuery('#message').text(data.message);   
               jQuery("form").trigger("reset");
 
            }else{
                jQuery('#survey_error_message').text(data);
                jQuery("form").trigger("reset");
            }
        
        },
        error: function(errorThrown){
        	console.log(errorThrown);
        }

    });  

    }
   
   });	



  /*==== Create Estimate invoice =======*/  

   jQuery(document).on('click', '#addInvoice', function () { 

   		console.log(111);
        
      var detaillist = [];
        
      $('.griditems').each(function () {
        var iindex = $(this).attr('itemindex');
        var product = $("#product"+iindex).val();
        var description = $("#description"+iindex).val();
        var qty = $("#qty"+iindex).val();
        var price = $("#price"+iindex).val();
        var total = $("#total"+iindex).val();

        detaillist.push({

          'product': product,
          'description': description,
          'qty'  : qty,
          'price' : price,
          'total' : total

        });

      });
       var dlist = JSON.stringify(detaillist);
       alert(dlist);
       
    

   			var estmateno = document.getElementById('estmateno').value;
   		  var itr_customer = document.getElementById('itr_customer').value;
   		  var cemail = document.getElementById('cemail').value;
   		  var itrestimate = document.getElementById('itrestimate').value;
   		  var itrstatusby = document.getElementById('itrstatusby').value;
   		  var itrstatusdate = document.getElementById('itrstatusdate').value;
   		  var caddress = document.getElementById('caddress').value;
   		  var bdate = document.getElementById('bdate').value;
   		  var epdate = document.getElementById('epdate').value;


        /*var product = document.getElementById('product').value;
        var description = document.getElementById('description').value;
        var qty = document.getElementById('qty').value;
        var price = document.getElementById('price').value;
        var total = document.getElementById('total').value;    */    
   		  
        var sub_total = document.getElementById('sub_total').value;
        var itr_est_message = document.getElementById('itr_est_message').value;
        var itr_state_message = document.getElementById('itr_state_message').value;  


    

			console.log(333);

		jQuery.ajax({
		url: ajax_url,
		type: "POST",
    cache: false,
		data: {
            'action':'new_db_estimate_info',

            'estmateno' : estmateno,
            'itr_customer' : itr_customer,
            'cemail' : cemail,
            'itrestimate' : itrestimate,
            'itrstatusby' : itrstatusby,
            'itrstatusdate' : itrstatusdate,
            'caddress' : caddress,
            'bdate' : bdate,
            'epdate' : epdate,

            'product' : dlist,
            'description' : dlist[description],
            'qty' : dlist[qty],
            'price' :dlist[price],
            'total' : dlist[total],
            
            'sub_total' : sub_total,
            'itr_est_message' : itr_est_message,
            'itr_state_message' : itr_state_message

        },
        success:function(data) {
     	    console.log(data);

        	  jQuery('body #message').html('Customer created successfully');
            if(data=='Message sent successfully'){
               jQuery('#message').text(data.message);   
               jQuery("form").trigger("reset");
 
            }else{
                jQuery('#survey_error_message').text(data);
                jQuery("form").trigger("reset");
            }
        
        },
        error: function(errorThrown){
        	console.log(errorThrown);
        }

      });

	  // }

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


 
  jQuery('#itr_inv_customer').on('change', function() {

     //let cstid = jQuery(this).val();
    var cstid = jQuery(this).find(":selected").val();
    //var dataString = 'empid='+ cstid;    
    
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
         //invdata = invdata[0];
        //jQuery('#result').text(invdata.itr_estimate_nbr);
        //var txt1 = nvdata.itr_estimate_nbr;
        jQuery('#result').append("<a href="+invdata.itr_estimate_nbr+">"+invdata.itr_estimate_nbr+"</a>");
        //jQuery('#result').text(invdata.email+invdata.baddress)
        jQuery('#caddress').val(invdata.baddress);
        jQuery('#cemail').val(invdata.email);
      },
      error: function() {
        alert('Error loading content.');
      }
    });
  });







 /*jQuery(document).ready(function() {

 jQuery('#itr_customer').autocomplete({
         source: function(request, response){
           jQuery.ajax({
                url: ajax_url,
                dataType: 'json',
                data: {
                    action: 'customer_name_autocomplete',
                    term: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function(event, ui){
            jQuery('#itr_customer').val(ui.item.value);

        }
    });
});


 jQuery(document).bind('click', '#itr_customer', function () {    
        var info = {
          "itr_customer": jQuery('#itr_customer').val()
      };
      jQuery.ajax({
        url : ajax_url, 
        type : "POST",
        dataType: 'json',
        data : info,
        data: {
              action: 'customer_info_autocomplete',
         },
        success : function(data) {
            response(data);
        },
        success : function(json) {
            jQuery('#caddress').val(json.baddress);
            jQuery('#cemail').val(json.email);
        },

  
    });
  });*/ 







	 



 

