<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 


/**
*  Overdue Report
*/

final class itr_overduereport{

  function __construct(){

   add_shortcode('overdue_report', [$this, 'itr_overdue_report']);             
 }  

 public function itr_overdue_report() {

  ?>

  <div class="row"> 

    <h4>Overdue Report</h4> 

    <div class="row">


      <table id="over_due_datas" class="table table-bordered">

        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Invoice No</th>
            <th>Total Amount</th>
            <th>Payment Last Date</th>
          </tr>
        </thead>


        <tbody id="over_due_list">
         
          <?php 
          global $wpdb;
          $cdate=date("Y-m-d"); 

          $over = $wpdb->get_results("SELECT 

            wp_invoice_info.itr_inv_expiration_date,
            wp_invoice_info.itr_invoice_nbr,
            wp_invoice_info.itr_inv_cust_id,
            wp_invoice_sub_total.itr_invoice_nbr,
            wp_invoice_sub_total.itr_invoice_total,
            wp_invoice_sub_total.itr_inv_cust_id,
            wp_customer_info.firstname,
            wp_customer_info.lastname,
            wp_customer_info.id

            FROM wp_invoice_info 
            LEFT JOIN wp_invoice_sub_total ON
            wp_invoice_info.itr_invoice_nbr = wp_invoice_sub_total.itr_invoice_nbr

            LEFT JOIN wp_customer_info ON
            wp_invoice_info.itr_inv_cust_id = wp_customer_info.id     
            
            WHERE wp_invoice_info.itr_inv_expiration_date <= '".$cdate."'
            ");
          foreach ( $over as $overlist ):
            ?>

            <tr>
              <td><?php echo $overlist->firstname.'&nbsp'.$overlist->lastname; ?><td>
                <td><?php echo $overlist->itr_invoice_nbr;?> <td>
                  <td><?php echo $overlist->itr_invoice_total;?><td>  
                    <td><?php echo $overlist->itr_inv_expiration_date;?><td>  
                    </tr>  

                  <?php endforeach; ?> 

                </tbody>
              </table>  

            </div> 

          </div>

          <div class="row copyright"> 
            <p>Built and maintained by <a href="https://itrtechsystems.com/">ITR Consulting</a> <strong>(www.itrtechsystems.com)</strong></p>

          </div>  

          <?php 
        }  

      } 
      ?>


