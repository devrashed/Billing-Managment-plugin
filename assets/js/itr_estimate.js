$(document).ready(function(){
    var i=1;
    $("#itradd_row").click(function()

    {
    	//b=i-1;
    	$("#itrtab_logic tbody").append('<tr id="itraddr'+i+'" class="griditems" itemindex="'+i+'">' +
              /*'<td>'+i+'</td>'+*/
              '<td><input type="text" name="product[]" id="product'+i+'" placeholder="Enter Product Name" class="form-control"/></td>'+

              '<td><input type="text" name="description[]" id="description'+i+'" placeholder="Enter Description Name" class="form-control"/></td>'+
              '<td><input type="text" name="qty[]" id="qty'+i+'" onkeypress="return isNumberKey(event)" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>'+
              '<td><input type="text" name="price[]" id="price'+i+'" onkeypress="return isNumberKey(event)" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/></td>'+
              '<td><input type="text" name="total[]" id="total'+i+'" placeholder="0.00" class="form-control total" readonly/></td>'+
           '</tr>');
      	i++; 
  	});

    $("#itrdelete_row").click(function(){
    	if(i>1){
		$("#itraddr"+(i-1)).html('');
		i--;
		}
		itrcalc();
	});
	
	$('#itrtab_logic tbody').on('keyup change',function(){
		itrcalc();
	});


});

function itrcalc()
{
	$('#itrtab_logic tbody tr').each(function(i, element) {
		var html = $(this).html();
		if(html!='')
		{
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			$(this).find('.total').val(qty*price);
			//$('#total').val(uqtotal.toFixed(2));
			itrcalc_total();
		}
    });
}

function itrcalc_total()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	$('#itramount').val(total.toFixed(2));
	
}


