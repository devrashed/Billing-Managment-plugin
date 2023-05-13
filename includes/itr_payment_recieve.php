      <?php 
      if ( ! defined('ABSPATH')) exit;  // if direct access 


   require 'itr_payment_recieve_db.php';

      final class itr_payment_recive {

        function __construct(){  

            new itr_paymentrecieve_db();    
            add_shortcode('itr_payment_recive', [$this, 'itr_add_payment_recive']);   
        }

        public function itr_add_payment_recive (){
          ?>

  <div class="row"> 
       <form method="POST" action="">

            <div class="row"> 
                <div class="col-md-12"><h3>Payment Recieve:</h3></div>
            </div>
            <div class="row"> 

               <div class="col-md-3"> 

                <span> Customer</span>            
                <select class="form-control" name="itr_pay_customer" id="itr_pay_customer">
                    <option value="" selected>--Select--</option>     
                </select>     
            </div>

            <div class="col-md-3"> 

              <span>Email</span>
              <input type="text" class="form-control" id="itr_payemail" name="itr_payemail" disabled required oninvalid="this.setCustomValidity('Insert Customer email')">      

          </div>

          <div class="col-md-6"> 
               <span> Invoice List </span> 
             <div id="invo_id"> </div>

          </div>

        </div>

        <br>
        <br>

        <div class="row"> 

         <div class="col-md-3"> 
            <span>Payment Date</span> 
            <input type="text" class="form-control" name="itr_paydate" id="itr_paydate" required="required" disabled>
         </div>  
        </div> 

        <br>
        <br>   
        
        <div class="row">  

          <div class="col-md-3"> 
            <span>Payment method</span> 
            
            <select class="form-control" name="itr_payment_method" id="itr_payment_method">
                <option value="" selected> Select payment Method</option>
                <option value="Cash"> Cash </option>
                <option value="Cheque"> Cheque </option>
                <option value="Credit Card"> Credit Card </option>
                <option value="Direct Debit"> Direct Debit </option>
          </select>    
        </div>  


        <div class="col-md-3"> 
            <span> Reference no.</span>  
             <input type="text" class="form-control" id="itr_pay_referance" name="itr_pay_referance">      
        </div>
         
        <div class="col-md-3"> 
            <span>Deposit to</span> 
            
            <select class="form-control" name="itr_deposit_type" id="itr_deposit_type">
                <option value="" selected> Select Deposit Type</option>
                <option value="Cash and cash equivalents"> Cash and cash equivalents </option>
                <option value="Allowance for bad debt"> Allowance for bad debt </option>
                <option value="Available for sale assets (short-term)">Available for sale assets (short-term)</option>
                <option value="Inventory">Inventory</option>
                <option value="Prepaid Expenses">Prepaid expenses</option>
                <option value="Uncategorised Asset">Uncategorised Asset</option>
                <option value="Undeposited Funds">Undeposited Funds</option>
          </select>    
           </div>
            <div class="col-md-3" id="itr_payment_amount"> 
        <span>Amount Received</span> 
        <input type="text" id="itr_payment_reciv" name='itr_payment_reciv' placeholder='0.00' disabled />

       </div>
        </div>


    <br>
    <br>
        <div class="row">

          <div class="col-md-12">  
            <table class="table table-bordered">
                 <thead>
                   <tr>
                    <th>DESCRIPTION</th>
                    <th>DUE DATE</th>
                    <th>ORIGINAL AMOUNT</th>
                    <th>OPEN BALANCE</th>
                    <th>DUE AMOUNT</th>
                    <th>PAYMENT</th>
                   </tr> 
                 </thead>   
             <tbody>
                   <tr> 
                    <td id="desc">&nbsp </td>
                    <td id="due_date"> &nbsp</td>
                    <td id="orginal_amount">&nbsp</td>
                    <td id="open_balance">&nbsp</td>
                    <td id="due_balance">&nbsp</td>
                    <td id="payment"> <input type="text" style="width: 70%; float: right;" id="itr_apply_amt" name='itr_apply_amt' placeholder='0.00'/> 
                  <input type="hidden" id="payment_nrb_recive" name="payment_nrb_recive">
                    </td>
                   </tr>
             </tbody>      
           </table>
          </div>     
        </div>    

        <div class="row" id="recive_payment_amount">
            <div class="col-md-9"></div>
            <div class="col-md-2"><span>Amount to Apply:</span></div>
            <div class="col-md-1"><span><div id="amount_apply">0.00</div></span></div>
        </div>
        <br>
        <br>

        <div class="row">

           <div class="col-md-4">  
            <span>Memo</span>
            <textarea class="form-control" id="itr_pay_sms" name="itr_pay_sms" rows="3"></textarea>
           </div>
           <div class="col-md-6"> <div id="pmessage"></div> 
            <span id="perror_message" style="color:red;"></span>
           </div>
           <div class="col-md-2">  <button type="button" id="ClearPayment" name="ClearPayment" class="btn btn-primary">Clear Payment</button> </div>
        </div>    
           
    </form>
</div>

   <div class="row copyright"> 
   <p>Built and maintained by <a href="https://itrtechsystems.com/">ITR Consulting</a> <strong>(www.itrtechsystems.com)</strong></p>

   </div> 

<script>


</script>    

    <?php

       }

    } /*end the class*/  

