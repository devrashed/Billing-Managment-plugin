<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  setting page
*/

final class itr_dbcustomer {


  function __construct(){
	add_action('wp_ajax_new_db_customer', [$this, 'new_db_customer']);
	add_action('wp_ajax_nopriv_new_db_customer', [$this,'new_db_customer']);
  }


  public function new_db_customer(){
    $post_data = wp_unslash( $_POST );

      global $wpdb;
      $table_name = $wpdb->prefix . 'customer_info';

       $wpdb->insert( $table_name, array(
            'firstname' => sanitize_text_field($post_data['firstname']), 
            'lastname' => sanitize_text_field($post_data['lastname']),
            'company' => sanitize_text_field($post_data['company']),
            'email' => sanitize_email($post_data['email']),
            'phonenumber' => sanitize_text_field($post_data['phonenumber']),
            'mobilenumber' => sanitize_text_field($post_data['mobilenumber']),
            'website' => sanitize_text_field($post_data['website']),
            'baddress' => sanitize_text_field($post_data['baddress']),
            'bcity' => sanitize_text_field($post_data['bcity']),
            'bstate' => sanitize_text_field($post_data['bstate']),
            'bpostalcode' => sanitize_text_field($post_data['bpostalcode']),
            'bcountry' => sanitize_text_field($post_data['bcountry']), 
            'shaddress'  => sanitize_text_field($post_data['shaddress']),  
            'shcity'    => sanitize_text_field($post_data['shcity']),
            'spostalcode' => sanitize_text_field($post_data['shpostalcode']),
            'shstate'  => sanitize_text_field($post_data['shstate']),
            'shcountry'  => sanitize_text_field($post_data['shcountry']),
            'bnotes'  => sanitize_text_field($post_data['bnotes']),
            'taxinfo' => sanitize_text_field($post_data['taxinfo']),
            /*'payment' => sanitize_text_field($post_data['payment']),
            'dmethod' => sanitize_text_field($post_data['dmethod']),
            'duerecipt'  => sanitize_text_field($post_data['duerecipt']),
            'balance'  => sanitize_text_field($post_data['balance']),
            'cdate'  => sanitize_text_field($post_data['cdate'])*/
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
                /*'%s',
                '%s',
                '%s',
                '%s',
                '%s'*/
            )
        );
        wp_send_json_success( array( 'message' => 'New Customer Successfully' ) );
        wp_die();
       
}






} /*end the class*/