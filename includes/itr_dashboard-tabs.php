<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
 *  setting page
 */
require_once 'itr_add_customer.php'; 
require_once 'itr_add_estimate.php'; 
require_once 'itr_create_invoice.php';
require_once 'itr_payment_recieve.php';

final class Itrtabs{

 function __construct(){

    new addcustomer(); 
    new add_estimate();
    new add_invoice();
    new itr_payment_recive();
    new itrtransection();

    add_shortcode('itr_tabs', [$this, 'dokan_get_dashboard_nav']); 

}

function dokan_get_dashboard_nav() {
    ?>

<div class="itr_season_tabs">
     <div class="itr_season_tab">
         <!-- <input type="radio" id="tab-1" name="tab-group-1" >
         <label for="tab-1">Dashboard</label> -->

         <div class="itr_season_content">
             <span>
                <!-- <div class="row">     

                   <div class="col-md-9"> 
                       <div class="itr_service">
                          <div class="add_customer"> </div>
                          Add Customer     
                      </div>

                      <div class="itr_service">
                          <div class="add_estimate">  </div>
                          Add Estimate    
                      </div>  

                      <div class="itr_service">
                          <div class="add_invoice">  </div>
                          Add Invoice    
                      </div>   

                      <div class="itr_service">
                          <div class="add_payment">  </div>
                          Recieve Payment   
                      </div>  
                  </div>    

                  <div class="col-md-3 card">
                       <h5 class="card-title">Total Recieve Payment :</h5>
                  <p class="card-text" id="total_recieve"> </p>     
               
                  </div>   

              </div> -->       

          </span>
      </div> 


  </div> <!-- First Tab -->

    <div class="itr_season_tab">
     <input type="radio" id="tab-2" name="tab-group-1" checked>
     <label for="tab-2">Add Customer</label>

     <div class="itr_season_content" style="">
         <?php echo do_shortcode( '[add_customer]' ); ?>
         <div class="clear"></div>
     </div> 
    </div>

    <div class="itr_season_tab">
     <input type="radio" id="tab-3" name="tab-group-1">
     <label for="tab-3">Estimate</label>

     <div class="itr_season_content">
         <?php echo do_shortcode( '[itr_estimate]' ); ?>
         <div class="clear"></div>
     </div> 
    </div>
    <div class="itr_season_tab">
     <input type="radio" id="tab-4" name="tab-group-1">
     <label for="tab-4">Invoice</label>

     <div class="itr_season_content">
         <span><?php echo do_shortcode('[itr_invoice]');?></span>
     </div> 
    </div>

    <div class="itr_season_tab">
     <input type="radio" id="tab-5" name="tab-group-1">
      <label for="tab-5">Recieve Payment</label>
       <div class="itr_season_content">
         <span><?php echo do_shortcode('[itr_payment_recive]');?></span>
      </div> 
     </div>
 

    <div class="itr_season_tab">
      <input type="radio" id="tab-6" name="tab-group-1">
       <label for="tab-6">All Customer List</label>
     <div class="itr_season_content">
         <span><?php echo do_shortcode('[show_customer]');?></span>
     </div> 
    </div>


 <div class="itr_season_tab">
       <input type="radio" id="tab-8" name="tab-group-1">
       <label for="tab-8">Total Estimate List</label>
     <div class="itr_season_content">
         <span><?php echo do_shortcode('[estimate_list]');?></span>
     </div> 
    </div>


    <div class="itr_season_tab">
       <input type="radio" id="tab-9" name="tab-group-1">
       <label for="tab-9">Total Invoice List</label>
     <div class="itr_season_content">
         <span><?php echo do_shortcode('[invoice_list]');?></span>
     </div> 
    </div>

    <div class="itr_season_tab">
      <input type="radio" id="tab-7" name="tab-group-1">
       <label for="tab-7">Receive Payment List</label>
     <div class="itr_season_content">
         <span><?php echo do_shortcode('[trans_report]');?></span>
     </div> 
   </div>

    <div class="itr_season_tab">
       <input type="radio" id="tab-10" name="tab-group-1" >
       <label for="tab-10">Overdue Report Generate</label>
     <div class="itr_season_content">
         <span><?php echo do_shortcode('[overdue_report]');?></span>
     </div> 
    </div>

    
<?php
  }

}
