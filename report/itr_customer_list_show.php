<?php 
  if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  Report DB
*/


final class itr_customerlist{

    function __construct(){

        add_shortcode('show_customer', [$this, 'customer_show_list']);             

    }

    public function customer_show_list(){
        ?>
<div class="row"> 
    
        <h4>Show Customer List</h4> 
        <div id="delmessage"> </div>
        <table id="show_data" class="table table-bordered">

            <thead>
                <tr>
                   <th>Customer Name</th>
                   <th>Company Name</th>
                   <th>Phone Number </th>
                   <th width="100">Email Address</th>
                   <!-- <th>Address</th>  -->
                   <th>Tax Info</th>
                   <th>Action</th>
               </tr>    

           </thead>


      <tbody id="list_show">
       <?php 
        global $wpdb;
        $show_customer = $wpdb->get_results( "SELECT * FROM wp_customer_info ORDER BY id DESC" );
        foreach ( $show_customer as $custlist ):

        ?> 
         <tr>
              <td><?php echo $custlist->firstname;?> <?php echo $custlist->lastname; ?></td>  
              <td><?php echo $custlist->company; ?></td>
              <td><?php echo $custlist->phonenumber; ?></td>
              <td><?php echo $custlist->email; ?></td>
              <!-- <td><?php //echo $custlist->baddress; ?>&nbsp <?php //echo $custlist->bcity; ?></td> -->
              <td><?php echo $custlist->taxinfo; ?></td>
              <td>
    <p><a href="#ex1" rel="modal:open" id="custshow" data-id="<?php echo $custlist->id; ?>">View</a></p>
    <button id="custdel" class="btn btn-danger" data-id="<?php echo $custlist->id; ?>">Delete</button>
          </td>
        </tr>    
   <?php endforeach; ?>  
</tbody> 


</table> 


    <div id="ex1" class="modal">

      <a href="#" rel="modal:close">Close</a>

    </div>


</div>

<div class="row copyright"> 
<p>Built and maintained by <a href="https://itrtechsystems.com/">ITR Consulting</a> <strong>(www.itrtechsystems.com)</strong></p>

</div>     

<!-- Link to open the modal -->


<!-- The Modal -->
<!-- <div id="myModal" class="modal">
  
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Some text in the Modal..</p>
</div></div> -->






<?php 
}  

}


?>