  <?php 
  if ( ! defined('ABSPATH')) exit;  // if direct access 


  require 'itr_create_invoice_db.php';

  final class add_invoice{


   function __construct(){ 

     new invoice_db(); 

     add_shortcode('itr_invoice', [$this, 'itr_add_invoice']);   

   }

   public function itr_add_invoice(){

    ?>

 <div class="row"> 

      <form method="POST" action="">
        
        <div class="row"> 
         <div class="col-md-12"><h3>Invoice</h3></div>
       </div>

       <div class="row"> 
         <div class="col-md-3"> 
          <span> Customer</span>            
          <select class="form-control" name="itr_inv_customer" id="itr_inv_customer">
            <option value="" selected>--Select--</option></select> 

          </div>

          <div class="col-md-3">
            <span>Email</span>
            <input type="text" class="form-control" id="itrinvemail" name="itrinvemail" disabled required oninvalid="this.setCustomValidity('Insert Customer email')">
          </div>

          <div class="col-md-3 itr_invrow">  <!-- onclick="itrgenerateInvoiceNumber()" -->

          </div>

          <div class="col-md-3"> 
           <!--  <span class="text-end">Amount</span>
            <input type="number" id="itr_inv_amount" name='itr_inv_amount' placeholder='0.00' class="form-control" readonly/> -->
            <div style="font-size: 14px;font-style:italic;margin: 4px 0px;">Estimate List: </div>
            <div id="result"></div>
          </div>
        </div>

        <br>
        <br>
        <div class="row">

          <div class="col-md-3"> 
           <span>Billing Address</span>
           <textarea class="form-control" id="itrinvaddress" name="itrinvddress" rows="3"></textarea>
         </div>
        
        <div class="col-md-2"> 
         <span>Estimate date</span>
         <input type="text" id="itr_invesdate" name='itr_invesdate' class="form-control" disabled readonly/>
       </div>
       <div class="col-md-2">
         <span>Expiration date</span>
        <input type="text" id="itr_invepdate" name='itr_invepdate' class="form-control" disabled readonly/>
       </div>
     </div> 

     <br>
     <br>

     <div class="row clearfix">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="itrinvtab_logic">
          <thead>
            <tr>

              <th class="text-center"> Product </th>
              <th class="text-center"> Desciption </th>
              <th class="text-center"> Qty </th>
              <th class="text-center"> Price </th>
              <th class="text-center"> Total </th>
            </tr>
          </thead>          

          <tbody class="invtbody">

          </tbody>

        </table>
      </div>
    </div>

    <div class="row clearfix">
      <div class="col-md-12">  
        <div id="itrinvadd_row">Add Row</div>
        <div id="itrinvdelete_row">Delete Row</div>
      </div>
    </div>


    <div class="row clearfix" >
      <div class="row">
        <div class="col-md-7"> </div>
        <div class="col-md-2 itrsub">Sub Total</div>
        <div class="col-md-3"><input type="number" name="invsub_total" placeholder='0.00' class="form-control" 
          id="invsub_total" readonly/> </div>
        </div>  

        <div class="row clearfix" style="margin-top:20px">
          <div class="col-md-7"> </div>
          <div class="col-md-2"> </div>
          <div class="col-md-3"> 
            <div id="valida_error_message"></div>
          </div>
        </div> 


        <div class="row">

          <div class="col-md-4">
           <span>Message on invoice</span>
           <textarea class="form-control" id="itr_invoice_message" name="itr_invoice_message" rows="3"></textarea>
         </div> 
         <div class="col-md-6"></div> 
         <div class="col-md-2"></div> 

       </div> 

       <br><br>
       <div class="row">
         <div class="col-md-4">
          <span>Message on statement</span>
          <textarea class="form-control" id="itr_inv_statement_message" name="itr_inv_statement_message" rows="3"></textarea> 
        </div> 
        <div class="col-md-6">

          <div id="imessage"></div>
          <span id="invalid_message" style="color:red;"></span>
          

        </div> 
        <div class="col-md-2">  <button type="button" id="addInvoice" name="addInvoice" class="btn btn-primary">Add invoice</button> 
        </div> 

      </div>  
    </form>

 </div>

   <div class="row copyright"> 
   <p>Built and maintained by <a href="https://itrtechsystems.com/">ITR Consulting</a> <strong>(www.itrtechsystems.com)</strong></p>

   </div>
  <?php
}

} /* END THE CLASS */
?>