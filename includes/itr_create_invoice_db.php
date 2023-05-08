<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  Invoice page
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*require 'tcpdf/tcpdf.php';

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';*/

final class invoice_db{
  
    function __construct(){ 
    
    add_action('wp_ajax_itr_invoice_display', [$this,'itr_invoice_display']);
    add_action('wp_ajax_nopriv_itr_invoice_display', [$this,'itr_invoice_display']);

    add_action('wp_ajax_itr_db_invoice_info', [$this, 'itr_db_invoice_info']);
    add_action('wp_ajax_nopriv_itr_db_invoice_info', [$this,'itr_db_invoice_info']); 

    add_action('wp_ajax_itr_allinvoice_show', [$this, 'itr_allinvoice_show']);
    add_action('wp_ajax_nopriv_itr_allinvoice_show', [$this,'itr_allinvoice_show']); 

    add_action('wp_ajax_customer_listshow_invoice', [$this, 'customer_listshow_invoice']);
    add_action('wp_ajax_nopriv_customer_listshow_invoice', [$this,'customer_listshow_invoice']); 

    add_action('wp_ajax_itr_click_invoice_showdate', [$this, 'itr_click_invoice_showdate']);
    add_action('wp_ajax_nopriv_itr_click_invoice_showdate', [$this,'itr_click_invoice_showdate']); 
    



    }

    function itr_invoice_display(){
    
            $cstid = $_GET['cstid'];
            global $wpdb;
            $inv_customer = $wpdb->get_results( "SELECT DISTINCT 
            
                wp_customer_info.id,
                wp_estimate_inv_info.itr_estimate_address, 
                wp_estimate_inv_info.itr_customer_email,
                wp_estimate_inv_info.itr_estimate_date,
                wp_estimate_inv_info.itr_estimate_inv_nbr,
                wp_estimate_inv_info.itr_est_status,
                wp_estimate_inv_info.itr_expiration_date
                FROM wp_customer_info 
                LEFT JOIN wp_estimate_inv_info ON 
                wp_estimate_inv_info.customer_id = wp_customer_info.id  
                WHERE wp_estimate_inv_info.itr_est_status = 1 AND wp_estimate_inv_info.customer_id  
                = '".$cstid."' " );

                echo wp_json_encode($inv_customer);
                wp_die();
        }

     

     public function itr_db_invoice_info(){

    $cdate=date("d-m-Y");  

     global $wpdb;
     $post_data = wp_unslash($_POST);
  
     $table_name = $wpdb->prefix . 'invoice_info';

     $wpdb->insert( $table_name, array(  

          'itr_inv_cust_id' => sanitize_text_field($post_data['itr_inv_customer']), 
          'itr_invoice_nbr' => sanitize_text_field($post_data['inv_esti_number']), 
          'itr_inv_customer_email' => sanitize_text_field($post_data['itrinvemail']), 
          'itr_invoice_baddress' => sanitize_text_field($post_data['itrinvaddress']),
          'itr_inv_estimate_date'  => sanitize_text_field($post_data['itr_invesdate']),
          'itr_inv_expiration_date' => sanitize_text_field($post_data['itr_invepdate']),
          'indate' =>$cdate,
          'itr_inv_status' => 1,
        ),
        array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
                
             )
            );
    
    
      foreach ($_POST['invlist'] as $data) {   
       $table_name = $wpdb->prefix . 'invoice_details';   

        $wpdb->insert($table_name, array(

        'itr_inv_customer_id' => sanitize_text_field($data['inv_custid']), 
        'itr_invoice_nbr' => sanitize_text_field($data['inv_esti_number']), 
        'itr_inv_pro_name' => sanitize_text_field($data['invproduct']), 
        'itr_inv_description' => sanitize_text_field($data['invdescription']), 
        'itr_inv_qtn'=> sanitize_text_field($data['invqty']), 
        'itr_inv_rate'=> sanitize_text_field($data['invprice']), 
        'itr_inv_total'=> sanitize_text_field($data['invtotal']),

            ),
     
          array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%f',
                '%f',
               

             )
          ); 

      }


         $table_name = $wpdb->prefix . 'invoice_sub_total';
         $wpdb->insert( $table_name, array(  

           'itr_inv_cust_id' => sanitize_text_field($post_data['itr_inv_customer']),  
           'itr_invoice_nbr' => sanitize_text_field($post_data['inv_esti_number']), 
           'itr_invoice_total' => sanitize_text_field($post_data['invsub_total']), 
           'itr_invoice_sms' => sanitize_text_field($post_data['itr_invoice_message']), 
           'itr_invoice_display_sms'  => sanitize_text_field($post_data['itr_inv_statement_message']),
           'subdate' => $cdate,
           'itr_sb_inv_status' => 1
         ),

         array(
         '%d',
         '%d',
         '%d',
         '%s',
         '%s',
         '%s',
         '%d'
             )
        );

        /* ===  Estimate status update === */ 

        $table_name = $wpdb->prefix . 'estimate_inv_info';

        $update_data = array(
        'itr_est_status' => 0,
        );
        $where = array(
        'itr_estimate_inv_nbr' => sanitize_text_field($post_data['inv_esti_number']),
        );

  
        $result = $wpdb->update( $table_name, $update_data, $where );
        
        
        /* === Estimate status update ===== */

        $table_name = $wpdb->prefix . 'estimate_sub_total';

        $update_data = array(
        'itr_sb_esti_status' => 0,
        );
        $where = array(
        'itr_estimate_nbr' => sanitize_text_field($post_data['inv_esti_number']),
        );


        $result = $wpdb->update( $table_name, $update_data, $where );
        
        $custid = sanitize_text_field($post_data['itr_inv_customer']);
        $incust = $wpdb->get_results("SELECT * FROM wp_customer_info WHERE id = '".$custid."'  ");


        /*===== pdf genareted script ====== */

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
        <td>'.$_POST['inv_esti_number'].'</td>
        </tr>
        <tr>
        <td>Date</td>
        <td>'.$_POST['itr_invesdate'].'</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr style="color: blue; font-size: 18px;">
        <td>Address</td>
        </tr>

        <tr>
        <td>'.$incust[0]->firstname.'  '.$incust[0]->lastname.'</td>
        </tr>
        <tr>
        <td>'.$incust[0]->company.'</td>
        </tr>
        <tr>
        <td>'.$incust[0]->bstate.'  '.$incust[0]->bpostalcode.' '.$incust[0]->bcountry.'</td>
        </tr>

        <tr>
        <td>Total Amount : </td>
        <td>'.'$'.$_POST['invsub_total'].'</td>
        </tr>

        </table>

        ');

        $invpdf = $pdf->Output('', 'S');


        /*===== Email HTML Template ====== */

        $invmessage .="<table style='width: 100%;'>";
        $invmessage .="<tr style='text-align: center;background-color: azure; height: 45px;'>";
        $invmessage .="<td>INVOICE NO".'&nbsp;'. sanitize_text_field($_POST["inv_esti_number"]).'&nbsp;'. "DETAILS</td>";
        $invmessage .="</tr>";
        $invmessage .="<tr style='text-align: center; height: 45px;'>";
        $invmessage .="<td>ITR SYSTEM</td>";
        $invmessage .="</tr>";     
        $invmessage .="<tr style='text-align: center; height: 30px;'>";
        $invmessage .="<td>DUE DATE :". sanitize_text_field($_POST['itr_invepdate'])."</td>";
        $invmessage .="</tr>";
        $invmessage .=" <tr style='text-align: center;background-color: azure; height:100px; align-items: center; font-size: 30px; font-weight: 600;'>";
        $invmessage .="<td>USD :". sanitize_text_field($_POST['invsub_total'])."</td>";
        $invmessage .=" </tr>";
        $invmessage .="<tr style='text-align: left; height:100px; font-size: 18px;'>";
        $invmessage .="<td>Dear".'&nbsp;'.$incust[0]->firstname.'&nbsp;'.$incust[0]->lastname.
        "<br>We appreciate your business. Please find your invoice details here.<br> Feel free to contact us if you have any questions.<br>
        Have a great day!";
        $invmessage .="</td></tr>";
        $invmessage .="<td><tr></td></tr>";
        $invmessage .="<td><tr></td></tr>";
        $invmessage .="<tr style='height:100px; font-size: 18px;'>";
        $invmessage .="<td style='text-align:left;'>Bill to :".'<br>'.
        $incust[0]->firstname.'&nbsp;'.$incust[0]->lastname.'<br>'.
        $incust[0]->company.'<br>'.
        $incust[0]->bcity.'<br>'.
        $incust[0]->bstate.'&nbsp;'.$incust[0]->bpostalcode.'&nbsp;'.$incust[0]->bcountry."</td>";
        $invmessage .="</tr></table>";  
      

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
        $mail->addAddress($incust[0]->email, '');     //Add a recipient 


        //Attachments
        $mail->addStringAttachment($invpdf, 'invoice.pdf');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Invoice No:".$_POST['inv_esti_number'].' '."From ITR System";
        $mail->Body    = $invmessage;
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
       /* $to = $incust[0]->email;
        $subject = "Invoice No:".sanitize_text_field($data["estmateno"]). "From ITR System";
        $message = $invmessage;
        $from    = $name . '<>' . $email;
        $header .= "Cc:firstmikebension@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $retval  = mail($to, $subject, $message, $header);*/    

        wp_send_json_success( array( 'imessage' => 'Invoice Create Successfully' ) );
        wp_die();  

    }


    public function itr_allinvoice_show (){
        global $wpdb;  
        $all_inv = $wpdb->get_results("SELECT * from wp_estimate_details 
        where itr_estimate_nbr = '".$_GET['invid']."'");

        echo wp_json_encode($all_inv);
        wp_die();    

    }   

    public function itr_click_invoice_showdate (){

        global $wpdb;  
        $all_inv = $wpdb->get_results("SELECT * from wp_estimate_inv_info 
        where itr_estimate_inv_nbr = '".$_GET['invid']."'");

        echo wp_json_encode($all_inv[0]);
        wp_die();    

    }
   

   public function customer_listshow_invoice (){
        global $wpdb;  

        $inv_customer = $wpdb->get_results('SELECT DISTINCT wp_estimate_details.customer_id,
          wp_customer_info.id,wp_customer_info.firstname, wp_customer_info.lastname FROM wp_customer_info RIGHT JOIN wp_estimate_details ON 
          wp_estimate_details.customer_id = wp_customer_info.id 
         

          ');

        echo wp_json_encode($inv_customer);
        wp_die();     

   }
   



}