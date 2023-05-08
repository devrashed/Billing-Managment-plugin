<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  estimate Database page 
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'tcpdf/tcpdf.php';

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

final class itr_dbestimate {


   function __construct(){
       

      //$mpdf = new \Mpdf\Mpdf();
           
      add_action('wp_ajax_new_db_estimate_info', [$this, 'new_db_estimate_info']);
      add_action('wp_ajax_nopriv_new_db_estimate_info', [$this,'new_db_estimate_info']); 


      add_action('wp_ajax_itr_estimate_display_custinfo', [$this, 'itr_estimate_display_custinfo']);
      add_action('wp_ajax_nopriv_itr_estimate_display_custinfo', [$this,'itr_estimate_display_custinfo']); 

      add_action('wp_ajax_itr_customer_list_show', [$this, 'itr_customer_list_show']);
      add_action('wp_ajax_nopriv_itr_customer_list_show', [$this, 'itr_customer_list_show']);

      add_action('wp_ajax_estimate_number_generte', [$this, 'estimate_number_generte']);
      add_action('wp_ajax_nopriv_estimate_number_generte', [$this, 'estimate_number_generte']);

      
   
    } 


     public function itr_estimate_display_custinfo(){


        $cid = $_GET['cid'];
        global $wpdb;
        $est_customer = $wpdb->get_results( "SELECT * FROM wp_customer_info WHERE id = '".$cid."'" );

        echo wp_json_encode($est_customer[0]);
        wp_die();
       
     }


  public function new_db_estimate_info(){

     $cdate=date("d-m-Y");
     
     global $wpdb;
     $post_data = wp_unslash($_POST);
  
     $table_name = $wpdb->prefix . 'estimate_inv_info';

     $wpdb->insert( $table_name, array(  

          'itr_estimate_inv_nbr' => sanitize_text_field($post_data['estmateno']), 
          'customer_id' => sanitize_text_field($post_data['itr_customer']), 
          'itr_customer_email' => sanitize_text_field($post_data['cemail']), 
          //'itr_estimate_status'  => sanitize_text_field($post_data['itrestimate']),
          'itr_status_by'    =>  sanitize_text_field($post_data['itrstatusby']),
          'itr_status_date'     =>  sanitize_text_field($post_data['itrstatusdate']),
          'itr_estimate_address' => sanitize_text_field($post_data['caddress']),
          'itr_estimate_date'  => sanitize_text_field($post_data['bdate']),
          'itr_expiration_date' => sanitize_text_field($post_data['epdate']),
          'estcdate'   =>  $cdate,
          'itr_est_status'=> 1,

        ),
        array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
             )
            );
        

     foreach ($_POST['dlist'] as $data) {   
       $table_name = $wpdb->prefix . 'estimate_details';   

        $wpdb->insert($table_name, array(

        'customer_id' => sanitize_text_field($data['itr_customer']), 
        'itr_estimate_nbr' => sanitize_text_field($data['estmateno']), 
        'itr_pro_name' => sanitize_text_field($data['product']), 
        'itr_description' => sanitize_text_field($data['description']), 
        'itr_qtn'=> sanitize_text_field($data['qty']), 
        'itr_rate'=> sanitize_text_field($data['price']), 
        'itr_rate_total'=> sanitize_text_field($data['total']),
            ),
     

          array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%f',
                '%f'
             )
          ); 

      }

    
         $table_name = $wpdb->prefix . 'estimate_sub_total';
         $wpdb->insert( $table_name, array(  
           'itr_estimate_nbr' => sanitize_text_field($data["estmateno"]),
           'customer_id' => sanitize_text_field($post_data['itr_customer']), 
           'itr_estimate_total' => sanitize_text_field($post_data['sub_total']), 
           'itr_estimate_sms' => sanitize_text_field($post_data['itr_est_message']), 
           'itr_display_sms'  => sanitize_text_field($post_data['itr_state_message']),
           'sbdate'   => $cdate,
           'itr_sb_esti_status'=> 1,
         ),

         array(
         '%d',
         '%d',
         '%s',
         '%s',
         '%s',
         '%s',
         '%d'

           )
        );


         
        /*==== Create pdf script ==== */ 

    $estimaetid = sanitize_text_field($post_data['estmateno']);
    $custid = sanitize_text_field($post_data['itr_customer']);
    $custname = $wpdb->get_results("SELECT * FROM wp_customer_info WHERE id = '".$custid."'  ");

    $custid = sanitize_text_field($post_data['itr_customer']);
    $duedate = sanitize_text_field($post_data["epdate"]);
    $custname = $wpdb->get_results("SELECT * FROM wp_customer_info WHERE id = '".$custid."'  ");     

    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', true);

    $pdf->SetTitle('');

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '');
    $pdf->writeHTML('
   <table style="width: 100%;">
  <tr>
    <td>ITR System<br>3030 Salt Creek Lane, Suite 145, Arlington Heights IL 60005</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>Estimate</td>
  <td>'.$_POST['estmateno'].'</td>
  </tr>
  <tr>
  <td>Date</td>
  <td>'.$_POST['epdate'].'</td>
  </tr>
 <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr style="color: blue; font-size: 18px;">
    <td>Address</td>
  </tr>

  <tr>
    <td>'.$custname[0]->firstname.'  '.$custname[0]->lastname.'</td>
  </tr>
  <tr>
    <td>'.$custname[0]->company.'</td>
  </tr>
  <tr>
    <td>'.$custname[0]->bstate.' '.$custname[0]->bpostalcode.' '.$custname[0]->bcountry.'</td>
  </tr>

  <tr>
  <td>Total Amount : </td>
  <td>'.'$'.$_POST['sub_total'].'</td>
  </tr>

  </table>

    ');

    $estpdf = $pdf->Output('', 'S');

        /*==== HTML Email Template ==== */ 


        $bodymessage .="<table style='width: 100%;'>";
        $bodymessage .="<tr style='text-align: center;background-color: azure; height: 45px;'>";
        $bodymessage .="<td>INVOICE NO".'&nbsp;'. sanitize_text_field($_POST["estmateno"]).'&nbsp;'. "DETAILS</td>";
        $bodymessage .="</tr>";
        $bodymessage .="<tr style='text-align: center; height: 45px;'>";
        $bodymessage .="<td>ITR SYSTEM</td>";
        $bodymessage .="</tr>";     
        $bodymessage .="<tr style='text-align: center; height: 30px;'>";
        $bodymessage .="<td>DUE DATE :". sanitize_text_field($_POST["epdate"])."</td>";
        $bodymessage .="</tr>";
        $bodymessage .=" <tr style='text-align: center;background-color: azure; height:100px; align-items: center; font-size: 30px; font-weight: 600;'>";
        $bodymessage .="<td>USD :". sanitize_text_field($_POST['sub_total'])."</td>";
        $bodymessage .=" </tr>";
        $bodymessage .="<tr style='text-align: left; height:100px; font-size: 18px;'>";
        $bodymessage .="<td>Dear".'&nbsp;'.$custname[0]->firstname.'&nbsp;'.$custname[0]->lastname.
        "<br>We appreciate your business. Please find your invoice details here.<br> Feel free to contact us if you have any questions.<br>
        Have a great day!";
        $bodymessage .="</td></tr>";
        $bodymessage .="<td><tr></td></tr>";
        $bodymessage .="<td><tr></td></tr>";
        $bodymessage .="<tr style='height:100px; font-size: 18px;'>";
        $bodymessage .="<td style='text-align:left;'>Bill to :".'<br>'.
        $custname[0]->firstname.'&nbsp;'.$custname[0]->lastname.'<br>'.
        $custname[0]->company.'<br>'.
        $custname[0]->bcity.'<br>'.
        $custname[0]->bstate.'&nbsp;'.$custname[0]->bpostalcode.'&nbsp;'.$custname[0]->bcountry."</td>";
        $bodymessage .="</tr></table>";  
      



        /*===== php emailer ====== */ 

        $mail = new PHPMailer(true);

        try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.itr.works';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'admin@itr.works';                     //SMTP username
        $mail->Password   = 'itrrashed@90';                               //SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


        //Recipients
        $mail->setFrom('email@itr.works', 'ITR system');
        $mail->addAddress($custname[0]->email, '');     //Add a recipient 


        //Attachments
        $mail->addStringAttachment($estpdf, 'Estimate.pdf');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Invoice No:".sanitize_text_field($data["estmateno"]).' '."From ITR System";
        $mail->Body    = $bodymessage;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        //$mail->send();
        if ($mail->send()) {
           // echo 'Email sent successfully';
        } else { 
            //echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        /*==== php mail functions ==== */ 


        /*$to = $custname[0]->email;
        $subject = "Invoice No:".sanitize_text_field($data["estmateno"]). "From ITR System";
        $message = $bodymessage;
        $from    = $name . '<>' . $email;
        //$header .= "Cc:firstmikebension@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $retval  = mail($to, $subject, $message, $header);*/
       

        wp_send_json_success( array( 'emessage' => 'Estimate Create successfully' ) );
        wp_die();  

        }




    public function estimate_number_generte() {
          global $wpdb;
   
          $table_name = $wpdb->prefix . 'estimate_number';
          $last_number = $wpdb->get_var("SELECT * FROM $table_name  ORDER BY itr_estimate_nbr DESC LIMIT 1");

          if (!$last_number) {
            $new_number = 1000;
          } else {
            $new_number = 1000 + $last_number;
          }

           $esti = $wpdb->insert( $table_name, array(
            'itr_estimate_nbr' => $new_number, 
          ),
           array(
            '%d'
           )
          );
         
         echo wp_send_json($new_number);
          wp_die();

            /*global $wpdb;
            $table_name = $wpdb->prefix . 'estimate_number';
            $last_id = $wpdb->get_var("SELECT MAX(itr_estimate_nbr) FROM $table_name");
            $next_id = $last_id ? $last_id + 1 : 1;
            $next_id = $next_id + 999; // add 999 to start from 1000
            return $next_id;
            //echo wp_json_encode($next_id);
            wp_die();*/

     }


     public function itr_customer_list_show() {
        global $wpdb; 
        $results = $wpdb->get_results("SELECT id,firstname,lastname FROM wp_customer_info");
        //echo wp_send_json($results);
        echo wp_json_encode($results);
        wp_die();  


     }

   

  
} /*END THE class*/
 