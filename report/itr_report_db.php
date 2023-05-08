<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  Report DB
*/

final class itr_reportdb{

   function __construct(){

   add_action('wp_ajax_itr_delete_customer_data', [$this,'itr_delete_customer_data']);
   add_action('wp_ajax_nopriv_itr_delete_customer_data', [$this,'itr_delete_customer_data']);

   add_action('wp_ajax_itr_estimate_total_amount', [$this,'itr_estimate_total_amount']);
   add_action('wp_ajax_nopriv_itr_estimate_total_amount', [$this,'itr_estimate_total_amount']);

   add_action('wp_ajax_itr_invoice_total', [$this,'itr_invoice_total']);
   add_action('wp_ajax_nopriv_itr_invoice_total', [$this,'itr_invoice_total']);

   add_action('wp_ajax_itr_show_customer_data', [$this,'itr_show_customer_data']);
   add_action('wp_ajax_nopriv_itr_show_customer_data', [$this,'itr_show_customer_data']);

   add_action('wp_ajax_itr_overdue_report', [$this,'itr_overdue_report']);
   add_action('wp_ajax_nopriv_itr_overdue_report', [$this,'itr_overdue_report']);
   
   add_action('wp_ajax_itr_list_show_customer', [$this,'itr_list_show_customer']);
   add_action('wp_ajax_nopriv_itr_list_show_customer', [$this,'itr_list_show_customer']);

   add_action('wp_ajax_itr_estimate_customer_list', [$this,'itr_estimate_customer_list']);
   add_action('wp_ajax_nopriv_itr_estimate_customer_list', [$this,'itr_estimate_customer_list']);

   add_action('wp_ajax_itr_invoice_customer_list', [$this,'itr_invoice_customer_list']);
   add_action('wp_ajax_nopriv_itr_invoice_customer_list', [$this,'itr_invoice_customer_list']);
   

   add_action('wp_ajax_itr_payment_recive_list', [$this,'itr_payment_recive_list']);
   add_action('wp_ajax_nopriv_itr_payment_recive_list', [$this,'itr_payment_recive_list']);

}      

/*==== Customer Estimate List total amount show  =======*/

  public function itr_estimate_total_amount(){
      global $wpdb;

      $table_name = $wpdb->prefix . 'estimate_sub_total';
      $total_pay = $wpdb->get_var("SELECT SUM(itr_estimate_total) as estimateamount FROM $table_name");
      echo wp_json_encode($total_pay);
      wp_die();
     } 

/*==== Customer Estimate List show  =======*/

     public function itr_estimate_customer_list(){

      global $wpdb;
      $est_info = $wpdb->prefix . 'estimate_inv_info';
      $est_details = $wpdb->prefix . 'estimate_details';
      $est_total = $wpdb->prefix . 'estimate_sub_total';
      $customer_info = $wpdb->prefix . 'customer_info';

      $estdata = $wpdb->get_results(" SELECT *
  
      FROM $est_info
      LEFT JOIN $est_total ON    
      $est_info.itr_estimate_inv_nbr = $est_total.itr_estimate_nbr
      LEFT JOIN $customer_info ON    
      $est_info.customer_id = $customer_info.id
     "); 
      echo wp_json_encode($estdata);
      wp_die();

     }

/*==== Customer Invocie list total amount show  =======*/

    public function itr_invoice_total(){
      global $wpdb;

      $table_name = $wpdb->prefix . 'invoice_sub_total';
      $total_pay = $wpdb->get_var("SELECT SUM(itr_invoice_total) as invpiceamount FROM $table_name");
      echo wp_json_encode($total_pay);
      wp_die();
     }  

    /*==== Customer Invoice List show  =======*/

    public function itr_invoice_customer_list(){

       global $wpdb;
      $inv_info = $wpdb->prefix . 'invoice_info';
      $inv_total = $wpdb->prefix . 'invoice_sub_total';
      $customer_info = $wpdb->prefix . 'customer_info';

      $invdata = $wpdb->get_results(" SELECT *
  
      FROM $inv_info
      LEFT JOIN $inv_total ON    
      $inv_info.itr_invoice_nbr = $inv_total.itr_invoice_nbr
      LEFT JOIN $customer_info ON    
      $inv_info.itr_inv_cust_id = $customer_info.id
     "); 
      echo wp_json_encode($invdata);
      wp_die();
    }



     /*==== Customer List show  =======*/

    public function itr_show_customer_data(){

      global $wpdb;
      $id = $_GET['id'];
      $custshow = $wpdb->get_results( "SELECT * FROM wp_customer_info WHERE id = '".$id."'" );
        
      echo wp_json_encode($custshow[0]);
      wp_die();

    }


    /*==== Receive Payment Report =======*/

    public function itr_payment_recive_list(){
        global $wpdb;
       $payment_recieve = $wpdb->prefix . 'payment_recieve';
        $customer_info = $wpdb->prefix . 'customer_info';
        $paydata = $wpdb->get_results("SELECT * FROM $payment_recieve
        LEFT JOIN $customer_info ON    
        $payment_recieve.itr_pay_cust_id = $customer_info.id");  

         echo wp_json_encode($paydata);
        wp_die();

    }

    /*==== Over Due Report =======*/   
    
     public function itr_overdue_report(){

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

      echo wp_json_encode($over);
      wp_die();


     }


     /*====== Cusomer list show ======= */

    public function itr_list_show_customer() {

     global $wpdb;
     $show_customer = $wpdb->get_results("SELECT * FROM wp_customer_info ORDER BY id DESC");

     echo wp_json_encode($show_customer);
     wp_die();
   
    }

     /*==== Customer Delete =======*/   

   public function itr_delete_customer_data() {

    ///$wpdb->delete( 'wp_customer_info', array( 'id' => $id ) );

    global $wpdb;
    $id = $_POST['id'];
    $wpdb->query(
      $wpdb->prepare(
        "DELETE wp_customer_info, wp_estimate_details, wp_estimate_inv_info, wp_estimate_sub_total, wp_invoice_details, wp_invoice_info, wp_invoice_sub_total, wp_payment_recieve
        FROM wp_customer_info
        LEFT JOIN wp_estimate_details ON wp_customer_info.id = wp_estimate_details.customer_id
        LEFT JOIN wp_estimate_inv_info ON wp_customer_info.id = wp_estimate_inv_info.customer_id
        LEFT JOIN wp_estimate_sub_total ON wp_customer_info.id = wp_estimate_sub_total.customer_id
        LEFT JOIN wp_invoice_details ON wp_customer_info.id = wp_invoice_details.itr_inv_customer_id
        LEFT JOIN wp_invoice_info ON wp_customer_info.id = wp_invoice_info.itr_inv_cust_id
        LEFT JOIN wp_invoice_sub_total ON wp_customer_info.id = wp_invoice_sub_total.itr_inv_cust_id
        LEFT JOIN wp_payment_recieve ON wp_customer_info.id = wp_payment_recieve.itr_pay_cust_id
        WHERE wp_customer_info.id = %d",
        $id
      )
    );
    $delcustomer = array('status' => true, 'message' => 'Customer deleted successfully');
    echo wp_json_encode($delcustomer);
    wp_die();

   }



} 