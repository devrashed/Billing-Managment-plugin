jQuery(document).ready(function($){
    var i=1;
    jQuery("#itradd_row").click(function()

    {
    	//b=i-1;
    	jQuery("#itrtab_logic tbody").append('<tr id="itraddr'+i+'" class="griditems" itemindex="'+i+'">' +
              /*'<td>'+i+'</td>'+*/
              '<td><input type="text" name="product[]" id="product'+i+'" placeholder="Enter Product Name" class="form-control"/></td>'+

              '<td><input type="text" name="description[]" id="description'+i+'" placeholder="Enter Description Name" class="form-control"/></td>'+
              '<td><input type="text" name="qty[]" id="qty'+i+'" onkeypress="return isNumberKey(event)" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>'+
              '<td><input type="text" name="price[]" id="price'+i+'" onkeypress="return isNumberKey(event)" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/></td>'+
              '<td><input type="text" name="total[]" id="total'+i+'" placeholder="0.00" class="form-control total" readonly/></td>'+
           '</tr>');
      	i++; 
  	});

    jQuery("#itrdelete_row").click(function(){
    	if(i>1){
		jQuery("#itraddr"+(i-1)).html('');
		i--;
		}
		itrcalc();
	});
	
	jQuery('#itrtab_logic tbody').on('keyup change',function(){
		itrcalc();
	});


});


function itrcalc()
{
	jQuery('#itrtab_logic tbody tr').each(function(i, element) {
		var html = jQuery(this).html();
		if(html!='')
		{
			var qty = jQuery(this).find('.qty').val();
			var price = jQuery(this).find('.price').val();
			jQuery(this).find('.total').val(qty*price);
			//jQuery('#total').val(uqtotal.toFixed(2));
			itrcalc_total();
		}
    });
}

function itrcalc_total()
{
	total=0;
	jQuery('.total').each(function() {
        total += parseInt(jQuery(this).val());
    });
	jQuery('#sub_total').val(total.toFixed(2));
	jQuery('#itramount').val(total.toFixed(2));
	
}


