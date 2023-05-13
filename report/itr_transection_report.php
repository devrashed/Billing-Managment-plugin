<?php 
  if ( ! defined('ABSPATH')) exit;  // if direct access 



require_once 'itr_report_db.php';

final class itrtransection
{
 
     function __construct()
      {

       new itr_reportdb(); 
       add_shortcode('trans_report', [$this, 'itr_report_transection']);             

      }  
  
    public function itr_report_transection(){

?>    

<div class="row"> 

    <h4>All Payment Recieve</h4> 
    <table id="transection_data" class="table table-bordered">

        <thead>
            <tr>
             <th>Customer Name</th>
             <th>Invoice No</th>
             <th>Payment Method</th>
             <th>Deposit to</th> 
             <th>Amount</th>  
             <th>Date</th>
             
         </tr>    

     </thead>



     <tbody id="customer_payment_list"> 

       <?php 
       global $wpdb;
       $payment_recieve = $wpdb->prefix . 'payment_recieve';
       $customer_info = $wpdb->prefix . 'customer_info';
       $data = $wpdb->get_results("SELECT * FROM $payment_recieve
        LEFT JOIN $customer_info ON    
        $payment_recieve.itr_pay_cust_id = $customer_info.id"); 
       foreach ( $data as $datalist ):
           ?>     

           <tr>
            <td><?php echo $datalist->firstname.'&nbsp'.$datalist->lastname; ?></td>
            <td><?php echo $datalist->itr_pay_invoice_nbr; ?></td>
            <td><?php echo $datalist->itr_payment_method; ?></td>
            <td><?php echo $datalist->itr_pay_deposit_to; ?></td>
            <td><?php echo $datalist->itr_total_payment_receive; ?></td>
            <td><?php echo $datalist->itr_pay_recive_date; ?></td>
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