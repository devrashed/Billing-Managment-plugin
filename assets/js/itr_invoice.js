jQuery(document).ready(function($){
     	//var i=1;
    jQuery("#itrinvadd_row").click(function()
 
 	   {
 	   	//var i=1;	
    	//b=i-1;
 	   	var i = jQuery('.invtbody tr').length;
 	   	
    	jQuery("#itrinvtab_logic tbody").append('<tr id="itrinvaddr'+i+'" class="invgriditems" invitemindex="'+i+'">' +
              /*'<td>'+i+'</td>'+*/
          '<td><input type="text" name="invproduct[]" id="invproduct'+i+'" placeholder="Enter Product Name" class="form-control"/></td>'+

          '<td><input type="text" name="invdescription[]" id="invdescription'+i+'" placeholder="Enter Description Name" class="form-control"/></td>'+
          '<td><input type="text" name="invqty[]" id="invqty'+i+'" onkeypress="return isNumberKey(event)" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>'+
          '<td><input type="text" name="invprice[]" id="invprice'+i+'" onkeypress="return isNumberKey(event)" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/></td>'+
          '<td><input type="text" name="invtotal[]" id="invtotal'+i+'" placeholder="0.00" class="form-control total"/></td>'+
           '</tr>');
      	i++; 
  	});

   /* $("#itrinvdelete_row").click(function(){
     var i = $('.invtbody tr').length;
     console.log(i);
    	if(i>1){
		$("#itrinvaddr"+(i-1)).html('');
		i--;
		}
		itrinvcalc();
	});*/

  jQuery("#itrinvdelete_row").click(function(){
    var i = jQuery('.invtbody tr').length; // get the number of rows in the table
    //console.log(i); // print the number of rows to the console
    if (i > 1) { // if there is more than 1 row
    	jQuery('.invtbody tr:last').remove(); // remove the last row
        //$("#itrinvaddr" + (i-1)).html(''); // delete the last row
        //i--; // decrement the row count
    }
    itrinvcalc(); // calculate the total
});
	
	jQuery('#itrinvtab_logic tbody').on('keyup change',function(){
		itrinvcalc();
	});


});

function itrinvcalc()
{
	var grandtotal = 0;
	//var abc = jQuery.noConflict();
	jQuery('#itrinvtab_logic tbody tr').each(function(i, element) {
	//$('.invtbody').each(function(i, element) {
		var html = jQuery(this).html();
		if(html!='')
		{
			var qty = jQuery(this).find('.qty').val();
			var price = jQuery(this).find('.price').val();
			jQuery(this).find('.total').val(qty*price);
			grandtotal = grandtotal + (qty*price);
			
		}
	});
		jQuery('#invsub_total').val(grandtotal);


}



/*function itrinvcalc_total()
{
	
	total=0;
	$('.total').each(function() {
        total += parseFloat($(this).val());
    });
	$('#invsub_total').val(total);
	//$('#itr_inv_amount').val(total.toFixed(2));
	
	
}*/