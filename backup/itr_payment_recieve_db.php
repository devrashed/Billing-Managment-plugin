<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  Payment recieve 
*/



final class itr_paymentrecieve_db{

   function __construct(){  

      add_shortcode('itr_payment_recive', [$this, 'itr_add_payment_recive']);   

      add_action('wp_ajax_itr_payeble_display', [$this,'itr_payeble_display']);
      add_action('wp_ajax_nopriv_itr_payeble_display', [$this,'itr_payeble_display']);

      add_action('wp_ajax_itr_subtotal_show', [$this,'itr_subtotal_show']);
      add_action('wp_ajax_nopriv_itr_subtotal_show', [$this,'itr_subtotal_show']);

      add_action('wp_ajax_itr_payment_recive_show', [$this,'itr_payment_recive_show']);
      add_action('wp_ajax_nopriv_itr_payment_recive_show', [$this,'itr_payment_recive_show']);

      add_action('wp_ajax_itr_duebalance_show', [$this,'itr_duebalance_show']);
      add_action('wp_ajax_nopriv_itr_duebalance_show', [$this,'itr_duebalance_show']);

      add_action('wp_ajax_itr_total_payment_recieve', [$this,'itr_total_payment_recieve']);
      add_action('wp_ajax_nopriv_itr_total_payment_recieve', [$this,'itr_total_payment_recieve']);

      add_action('wp_ajax_itr_customer_payment_recieve', [$this,'itr_customer_payment_recieve']);
      add_action('wp_ajax_nopriv_itr_customer_payment_recieve', [$this,'itr_customer_payment_recieve']);

      
    }


   function itr_customer_payment_recieve (){
    global $wpdb;  

    $inv_customer = $wpdb->get_results('SELECT DISTINCT 
      wp_invoice_info.itr_inv_cust_id,
      wp_customer_info.id,

      wp_customer_info.firstname, 
      wp_customer_info.lastname

      FROM wp_customer_info RIGHT JOIN wp_invoice_info ON 
      wp_invoice_info.itr_inv_cust_id = wp_customer_info.id');

    echo wp_json_encode($inv_customer);
    wp_die(); 
      }

    public function itr_payeble_display(){

         $cstid = $_GET['cstid'];
         global $wpdb;

          /*$pay_customer = $wpdb->get_results( "SELECT DISTINCT 
          wp_invoice_sub_total.itr_inv_cust_id,
          wp_invoice_sub_total.itr_invoice_total,
  
          wp_invoice_info.itr_inv_cust_id,
          wp_invoice_info.itr_invoice_nbr,
          wp_invoice_info.itr_inv_customer_email,
          wp_invoice_info.itr_inv_cust_id,
          wp_invoice_info.itr_inv_expiration_date             
          FROM wp_invoice_sub_total 
          LEFT JOIN wp_invoice_info ON
          wp_invoice_sub_total.itr_inv_cust_id = wp_invoice_info.itr_inv_cust_id    
          WHERE 
          wp_invoice_sub_total.itr_inv_cust_id = '".$cstid."' " );*/

          $pay_customer = $wpdb->get_results( "SELECT DISTINCT 
          wp_invoice_info.itr_inv_customer_email,
          wp_invoice_sub_total.itr_invoice_nbr
                     
          FROM wp_invoice_sub_total 
          LEFT JOIN wp_invoice_info ON
          wp_invoice_sub_total.itr_inv_cust_id = wp_invoice_info.itr_inv_cust_id  
          LEFT JOIN wp_payment_recieve ON
          wp_invoice_sub_total.itr_invoice_nbr = wp_payment_recieve.itr_pay_invoice_nbr

          WHERE wp_invoice_sub_total.itr_invoice_total > 
      
    IFNULL ((select sum(wp_payment_recieve.itr_total_payment_receive) 
from wp_payment_recieve  WHERE wp_payment_recieve.itr_pay_invoice_nbr = wp_invoice_sub_total.itr_invoice_nbr),0) AND
 
          wp_invoice_sub_total.itr_inv_cust_id = '".$cstid."'

            ");

          echo wp_json_encode($pay_customer);
          wp_die();

    }


      public function itr_subtotal_show(){

      $invo = $_GET['invo'];
      global $wpdb;
      
      $pay_subtotal = $wpdb->get_results( "SELECT *

          FROM wp_invoice_sub_total 
          LEFT JOIN wp_invoice_info ON    
          wp_invoice_sub_total.itr_invoice_nbr = wp_invoice_info.itr_invoice_nbr
          LEFT JOIN wp_payment_recieve ON
          wp_invoice_sub_total.itr_invoice_nbr = wp_payment_recieve.itr_pay_invoice_nbr
          WHERE wp_invoice_info.itr_invoice_nbr = '".$invo."' 
          ORDER BY wp_payment_recieve.id DESC LIMIT 1
        ");

      echo wp_json_encode($pay_subtotal[0]);
      wp_die();

      }

      public function itr_duebalance_show (){
      $invoid = $_GET['invoid'];
      global $wpdb;

      $pay_openbalance = $wpdb->get_results( "
        SELECT SUM(wp_payment_recieve.itr_total_payment_receive) as totalbalance,
       wp_invoice_sub_total.itr_invoice_total,
        wp_payment_recieve.itr_pay_invoice_nbr,
        wp_invoice_sub_total.itr_invoice_nbr
        FROM wp_payment_recieve 
        LEFT JOIN wp_invoice_sub_total ON 
        wp_payment_recieve.itr_pay_invoice_nbr = wp_invoice_sub_total.itr_invoice_nbr
        WHERE wp_payment_recieve.itr_pay_invoice_nbr = '".$invoid."'
        GROUP BY
        wp_invoice_sub_total.itr_invoice_total,
        wp_payment_recieve.itr_pay_invoice_nbr,
        wp_invoice_sub_total.itr_invoice_nbr 

        ");
        
      echo wp_json_encode($pay_openbalance[0]);
      wp_die();
      }


      public function itr_payment_recive_show(){
       global $wpdb;
       $cdate=date("Y-m-d");  
       $post_data = wp_unslash($_POST);

       $table_name = $wpdb->prefix . 'payment_recieve';
         $wpdb->insert( $table_name, array(  
           'itr_pay_cust_id' => sanitize_text_field($post_data["itr_pay_customer"]),
           'itr_pay_invoice_nbr' => sanitize_text_field($post_data['payment_nrb_recive']), 
           'itr_payment_date' => sanitize_text_field($post_data['itr_paydate']),  
           'itr_payment_method' => sanitize_text_field($post_data['itr_payment_method']),
           'itr_pay_refarance_no' => sanitize_text_field($post_data['itr_pay_referance']),
           'itr_pay_deposit_to' => sanitize_text_field($post_data['itr_deposit_type']),
           'itr_total_payment_receive' =>sanitize_text_field($post_data['itr_apply_amt']),
           'itr_pay_recive_memo' =>sanitize_text_field($post_data['itr_pay_sms']),
           'itr_pay_recive_date' => $cdate,
         ),

         array(
         '%d',
         '%d',
         '%s',
         '%s',
         '%s',
         '%s',
         '%d',
         '%s',
         '%s'
             )
        );


        $custid = sanitize_text_field($post_data['itr_pay_customer']);

        $invtotal = $wpdb->get_results("SELECT * FROM wp_invoice_sub_total WHERE itr_inv_cust_id = '".$custid."'  ");

        $incust = $wpdb->get_results("SELECT * FROM wp_customer_info WHERE id = '".$custid."'  ");

        $invmessage .="<table style='width: 100%;'>";
        $invmessage .="<tr style='text-align: center;background-color: azure; height: 45px;'>";
        $invmessage .="<td>INVOICE NO".'&nbsp;'. sanitize_text_field($_POST["payment_nrb_recive"]).'&nbsp;'. "DETAILS</td>";
        $invmessage .="</tr>";
        $invmessage .="<tr style='text-align: center; height: 45px;'>";
        $invmessage .="<td>ITR SYSTEM</td>";
        $invmessage .="</tr>";     
        $invmessage .="<tr style='text-align: center; height: 30px;'>";
        $invmessage .="<td>DUE DATE :". sanitize_text_field($_POST['itr_paydate'])."</td>";
        $invmessage .="</tr>";
        $invmessage .=" <tr style='text-align: center;background-color: azure; height:100px; align-items: center; font-size: 30px; font-weight: 600;'>";
        $invmessage .="<td>USD :". $invtotal[0]->itr_invoice_total."</td>";
        $invmessage .=" </tr>";
        $invmessage .="<tr style='text-align: left; height:100px; font-size: 17px;'>";
        $invmessage .="<td>Dear".'&nbsp;'.$incust[0]->firstname.'&nbsp;'.$incust[0]->lastname.
        "<br>We appreciate your business. Please find your invoice details here.<br> Feel free to contact us if you have any questions.<br>
        Have a great day!";
        $invmessage .="</td></tr>";
        $invmessage .="<tr><td></td></tr>";
        $invmessage .="<tr><td></td></tr>";
        $invmessage .="<tr style='height:100px; font-size: 17px;'>";
        $invmessage .="<td style='text-align:left;'>Bill to :".'<br>'.
        $incust[0]->firstname.'&nbsp;'.$incust[0]->lastname.'<br>'.
        $incust[0]->company.'<br>'.
        $incust[0]->bcity.'<br>'.
        $incust[0]->bstate.'&nbsp;'.$incust[0]->bpostalcode.'&nbsp;'.$incust[0]->bcountry."</td>";
        $invmessage .="</tr>";  
        $invmessage .="<tr><td></td></tr>";
        $invmessage .="<tr><td></td></tr>";

        $invmessage .="<tr style='text-align:left; font-size: 17px; font-weight: 600;'>";
        $invmessage .="<td>Payment method</td>";
        $invmessage .="<td>Reference no.</td>";
        $invmessage .="<td>Deposit to</td>";
        $invmessage .="<td>Recieve Payment</td></tr>";

        $invmessage .="<tr style='text-align:left; font-size: 16px;'>";
        $invmessage .="<td>".sanitize_text_field($_POST['itr_payment_method'])."</td>";
        $invmessage .="<td>".sanitize_text_field($_POST['itr_pay_referance'])."</td>";
        $invmessage .="<td>".sanitize_text_field($_POST['itr_deposit_type'])."</td>";
        $invmessage .="<td>".sanitize_text_field($_POST['itr_apply_amt'])."</td>";
        $invmessage .="</tr>";  
        $invmessage .="<tr><td></td></tr>";
        $invmessage .="<tr><td></td></tr>";

        $invmessage .="<tr style='text-align:left; font-size: 17px; font-weight: 600;'>";
        $invmessage .="<td>Memo</td></tr>"; 
        $invmessage .="<tr style='text-align:left; font-size: 17px;'>";
        $invmessage .="<td>".sanitize_text_field($_POST['itr_pay_sms'])."</td>";
        $invmessage .="</tr></table>";  
      
        $to = $incust[0]->email;
        $subject = "Invoice No:".sanitize_text_field($data["estmateno"]). "From ITR System";
        $message = $invmessage;
        $from    = $name . '<>' . $email;
        $header .= "Cc:firstmikebension@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $retval  = mail($to, $subject, $message, $header);


        wp_send_json_success( array( 'message' => 'Payment Received Successfully' ) );
        wp_die();
      }  


    public function itr_total_payment_recieve(){
      global $wpdb;

      $table_name = $wpdb->prefix . 'payment_recieve';
      $total_pay = $wpdb->get_var("SELECT SUM(itr_total_payment_receive) as recivepayment FROM $table_name");

      echo wp_json_encode($total_pay);
      wp_die();
     }  




} /*end the class*/
