<?php 
  if ( ! defined('ABSPATH')) exit;  // if direct access 



final class itr_estimatelist{


 function __construct(){

       add_shortcode('estimate_list', [$this, 'itr_report_estimate']);             
   }  

    public function itr_report_estimate() {

  ?>

 <div class="row"> 

    <h4>All Estimate List</h4> 
    <div class="row"> 

        <div class="col-md-9"></div>
        <div class="col-md-3 card">

            <h5 class="card-title">Total Estimate Amount :</h5>
            <p class="card-text" id="estimate_total"> </p>     

         </div>   

    </div>  

     <table id="estimate_list_show" class="table table-bordered">
    
      <thead>
          <tr>
               <th>Customer Name</th>
               <th>Invoice No</th>
               <th>Estimate date</th> 
               <th>Expiration date</th>  
               <th>Amount</th>     

          </tr>    
      </thead>

      <tbody id="estimate_list">

      <?php 
        global $wpdb;
        $est_info = $wpdb->prefix . 'estimate_inv_info';
        $est_details = $wpdb->prefix . 'estimate_details';
        $est_total = $wpdb->prefix . 'estimate_sub_total';
        $customer_info = $wpdb->prefix . 'customer_info';

        $data = $wpdb->get_results(" SELECT *
    
        FROM $est_info
        LEFT JOIN $est_total ON    
        $est_info.itr_estimate_inv_nbr = $est_total.itr_estimate_nbr
        LEFT JOIN $customer_info ON    
        $est_info.customer_id = $customer_info.id
       "); 

        foreach ( $data as $datalist ):
       
       ?>

          <tr>
            <td><?php echo $datalist->firstname;?> <?php echo $datalist->lastname;?></td>
            <td><?php echo $datalist->itr_estimate_inv_nbr;?></td>
            <td><?php echo $datalist->itr_estimate_date;?></td>
            <td><?php echo $datalist->itr_expiration_date;?></td>
            <td><?php echo $datalist->itr_estimate_total;?></td> 
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


