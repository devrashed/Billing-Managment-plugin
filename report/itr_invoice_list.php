<?php 
  if ( ! defined('ABSPATH')) exit;  // if direct access 



final class itr_invoicelist{


 function __construct(){

       add_shortcode('invoice_list', [$this, 'itr_report_invoice']);             
   }  

    public function itr_report_invoice() {

  ?>

<div class="row"> 
  <h4>All Invoice List</h4> 

  <div class="row"> 

      <div class="col-md-9"></div>
      <div class="col-md-3 card">

          <h5 class="card-title">Total Invoice Amount :</h5>
          <p class="card-text" id="invoice_total"> </p>     

       </div>   

  </div>  

   <table id="invoice_list" class="table table-bordered">
  
    <thead>
        <tr>
             <th>Customer Name</th>
             <th>Invoice No</th>
             <th>Estimate date</th> 
             <th>Expiration date</th>  
             <th>Amount</th>     
             <!-- <th>Date</th>  -->
        </tr>    
    </thead>
     
    <tbody id="customer_invoice_list">

    <?php 
      global $wpdb;
      $inv_info = $wpdb->prefix . 'invoice_info';
      $inv_total = $wpdb->prefix . 'invoice_sub_total';
      $customer_info = $wpdb->prefix . 'customer_info';

      $data = $wpdb->get_results(" SELECT *
  
      FROM $inv_info
      LEFT JOIN $inv_total ON    
      $inv_info.itr_invoice_nbr = $inv_total.itr_invoice_nbr
      LEFT JOIN $customer_info ON    
      $inv_info.itr_inv_cust_id = $customer_info.id
     "); 

      foreach ( $data as $datalist ):
     
     ?>

        <tr>
          <td><?php echo $datalist->firstname;?> <?php echo $datalist->lastname;?></td>
          <td><?php echo $datalist->itr_invoice_nbr;?></td>
          <td><?php echo $datalist->itr_inv_estimate_date;?></td>
          <td><?php echo $datalist->itr_inv_expiration_date;?></td>
          <td><?php echo $datalist->itr_invoice_total;?></td> 
        </tr> 
      <?php endforeach; ?>  
    
    </tbody>    

  </table>

</div>

<div class="row copyright"> 
<p>Built and maintained by <a href="https://itrtechsystems.com/">ITR Consulting</a> <strong>(www.itrtechsystems.com)</strong></p>

</div>    

<?php 
    }  

   } 
?>


