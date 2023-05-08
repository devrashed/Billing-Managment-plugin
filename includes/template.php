<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>

<?php 
    $subject = "Query about your product";
    $message = "Senders Email :".$email."\r\n Name:".$name."\r\n Message:".$message;
    $from    = $name . '' . $email;
    $header .= "Cc:impulse.khan@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    $retval  = mail($to, $subject, $message, $header);


       $bodymessage="<table style='background-color: azure; width:100%;'>
        <tr>
        <td>Due Date:".sanitize_text_field($_POST["epdate"])."</td>
        <td>Bill To:".$custname[0]->firstname.''.$custname[0]->lastname."</td>
        </tr>  
   </table>";
   

?>


 <?php
// recipient email address
$to = "recipient@example.com";

// subject of the email
$subject = "Email with Attachment";

// message body
$message = "This is a sample email with attachment.";

// from
$from = "sender@example.com";

// boundary
$boundary = uniqid();

// header information
$headers = "From: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\".$boundary.\"\r\n";

// attachment
$attachment = chunk_split(base64_encode(file_get_contents('file.pdf')));

// message with attachment
$message = "--".$boundary."\r\n";
$message .= "Content-Type: text/plain; charset=UTF-8\r\n";
$message .= "Content-Transfer-Encoding: base64\r\n\r\n";
$message .= chunk_split(base64_encode($message));
$message .= "--".$boundary."\r\n";
$message .= "Content-Type: application/octet-stream; name=\"file.pdf\"\r\n";
$message .= "Content-Transfer-Encoding: base64\r\n";
$message .= "Content-Disposition: attachment; filename=\"file.pdf\"\r\n\r\n";
$message .= $attachment."\r\n";
$message .= "--".$boundary."--";

// send email
if (mail($to, $subject, $message, $headers)) {
    echo "Email with attachment sent successfully.";
} else {
    echo "Failed to send email with attachment.";
}
?>


<?php 
// Register the hook to generate PDF invoice
add_action( 'wp_loaded', 'register_generate_pdf_invoice_hook' );
function register_generate_pdf_invoice_hook() {
    add_action( 'generate_pdf_invoice', 'generate_pdf_invoice_callback' );
}

// Callback function to generate PDF invoice
function generate_pdf_invoice_callback() {
    // Code to fetch billing data and generate PDF invoice
    // ...

    // Output the PDF invoice as a download
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="invoice.pdf"');
    readfile($pdf_file_path); // replace with your actual file path
    exit();
}


Eikhane, wp_loaded action er moddhe amra register_generate_pdf_invoice_hook callback function ke add korechi. Eita shesh hote na hole, invoice generate hoye jabe na. Callback function er moddhe amra generate_pdf_invoice hook ke add korechi.

Callback function er moddhe amra billing data fetch kore nie PDF invoice generate kore $pdf_file_path e save korechi. Finally, header ebong readfile() functions use kore, invoice ke download attachment hishabe dekhano hoyeche.
?>
    





    $content .= "<table style='width: 100%;'>";
    $content .= "<tr>"; 
    $content .= "<td>ITR System<br>3030 Salt Creek Lane, Suite 145, Arlington Heights IL 60005</td>";
    $content .= "<td></td>";
    $content .= "</tr>"; 
    $content .= "<tr>";
    $content .= "<tr><td>&nbsp;</td><td></td><td></td></tr>";

    $content .= "<tr><td><span style='color: blue; font-size: 18px;'>Estimate </span><br>
    <span style='font-size: 16px;'>Address</span>"
    .$custname[0]->firstname.' '.$custname->lastname.'<br>'.
    $custname[0]->company.'<br>'.
    $custname[0]->baddress.'<br>'.
    $custname[0]->bcity.' '.$custname[0]->bstate.'  '.$custname[0]->bpostalcode.' '.$custname[0]->bcountry."</td>";
    $content .= "<td>ESTIMATE :<br>DATE :</td>";
    $content .= "<td>".sanitize_text_field($_POST["estmateno"])."<br>".sanitize_text_field($_POST["bdate"]).
    "</td></tr></table>";

<tr style="background-color: rgb(89, 208, 208); padding: 10px 0px;">
    <td>SERVICE</td>
    <td>DESCRIPTION</td>
    <td>QTY</td>
    <td>RATE</td>
    <td>AMOUNT</td>
</tr>    

    $estdata = $wpdb->get_results("SELECT * FROM wp_estimate_details where itr_estimate_nbr = $estimaetid"); 
    foreach ($estdata as $estdatalist ):

<tr>
    <td> $estdatalist->itr_pro_name</td>
    <td> $estdatalist->itr_description</td>
    <td> $estdatalist->itr_qtn</td>
    <td> $estdatalist->itr_rate</td>
    <td> $estdatalist->itr_rate_total</td>
</tr>  
    endforeach; 

 $esttotal = $wpdb->get_results("SELECT * FROM wp_estimate_sub_total where itr_estimate_nbr = $estimaetid"); 
 foreach ($esttotal as $esttotal ):
?> 


<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Total</td>
    <td>&nbsp;</td>
    <td>$esttotal->itr_estimate_total</td>
</tr>
  endforeach

</table>';

</body>
</html>






