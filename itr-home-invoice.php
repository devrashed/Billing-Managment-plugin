<?php
/**
 * Plugin Name: ITR invoice System 
 * Description: ITR invoice System 
 * Plugin URI: https://itrtechsystems.com/
 * Author: Rashed khan
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html 
 */


if ( ! defined('ABSPATH')) exit;  // if direct access 

require_once 'includes/itr_dashboard-tabs.php'; 
require_once 'includes/itr_estimate_db.php'; 
require_once 'report/itr_transection_report.php'; 
require_once 'report/itr_customer_list_show.php'; 
require_once 'report/itr_estimate_list.php';
require_once 'report/itr_invoice_list.php';
require_once 'report/itr_overdue_report.php';

final class itrinvoice
 {

  const version = '1.0';

  function __construct()
  {
    $this->itrinvoice_define_constants(); //define asstes

    register_activation_hook( ITRINVOICE_ASSETS_FILE, [ $this, 'itrinvoice_assets_activate' ] ); // plugin activation

    add_action( 'wp_enqueue_scripts', [$this, 'invoice_enqueue_assets']);   
    add_action( 'plugins_loaded', [ $this, 'itrinvoice_assets_init_plugin' ] );  // load plugin

  }

  public function invoice_enqueue_assets() {
  
    wp_enqueue_script( 'jQuery-min', 'https://code.jquery.com/jquery-3.6.0.js', 0.132, true );


     wp_enqueue_script( 'jQuery-modal', plugins_url('/assets/js/jquery.modal.min.js' , __FILE__ ) , array('jquery'), '1.14.4', true);


    wp_enqueue_script( 'jquerydata', plugins_url('/assets/js/jquery.dataTables.min.js' , __FILE__ ) , array('jquery'), '1.13.4', true);


    wp_enqueue_script( 'jquerybootstarp', plugins_url('/assets/js/dataTables.bootstrap5.min.js' , __FILE__ ) , array('jquery'), '1.13.4', true);
  

    wp_enqueue_style( 'bootstrapcss', plugins_url('/assets/css/bootstrap.min.css' , __FILE__ ) , array(), '1.3.0', false );
    

    wp_enqueue_style( 'dashboard-css', plugins_url('/assets/css/style.css' , __FILE__ ) , array(), '1.4.0', false );


    wp_enqueue_style( 'jQuery-modal-css',plugins_url('/assets/css/jquery.modal.min.css' , __FILE__ ) , array(), '1.5.0', false );


    wp_enqueue_script( 'itrestimate', plugins_url('/assets/js/itr_estimate.js' , __FILE__ ) , array('jquery'), '1.3.0', true);

    wp_enqueue_script( 'itrinvoice', plugins_url('/assets/js/itr_invoice.js' , __FILE__ ) , array('jquery'), '1.6.0', true);

    wp_enqueue_script( 'customjs', plugins_url('/assets/js/itr_customjs.js' , __FILE__ ) , array('jquery'), '1.3.0', true);

    wp_localize_script( 'customjs', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );


    wp_enqueue_script( 'reportjs' , plugins_url('/assets/js/itr_report.js' , __FILE__ ) , array('jquery'), '1.3.0', true);

    wp_localize_script( 'reportjs', 'ajax_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );


    wp_enqueue_style( 'font-awesome','https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css' , array(), '1.9.0', false );

}



   /**
     * Define the required plugin constants
     *
     * @return void
     */ 

   public function itrinvoice_define_constants() {
     define( 'ITRINVOICE_ASSETS_VERSION', self::version );
     define( 'ITRINVOICE_ASSETS_FILE', __FILE__ );
     define( 'ITRINVOICE_ASSETS_PATH', __DIR__ );
     define( 'ITRINVOICE_ASSETS_URL', plugin_dir_url( __FILE__  ) );
   }


   public function itrinvoice_assets_init_plugin() {

     new Itrtabs();
     new itr_customerlist();
     new itr_estimatelist();
     new itr_invoicelist();
     new itr_overduereport();

   }

   public function itrinvoice_assets_activate() {

    $installed = get_option( 'itrinvoice_installed' );

    if ( ! $installed ) {
     update_option( 'itrinvoice_installed', time() );
    }

   update_option( 'itrinvoice_assets_version', ITRINVOICE_ASSETS_VERSION );
  } 

}  


new itrinvoice ();
