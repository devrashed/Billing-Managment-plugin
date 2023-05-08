<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
*  customer create 
*/

require_once 'itr_customer_add_db.php'; 

final class addcustomer {

   function __construct(){

      new itr_dbcustomer();
      add_shortcode('add_customer', [$this, 'itr_add_customer']);
   
   } 

   public function itr_add_customer(){

      ?>
      <h5> Customer Information </h5>

      <form method="POST" action="">
      <div class="row">

         <div class="col-md-6"> 

            <div class="row">

               <div class="col-md-6">

            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required oninvalid="this.setCustomValidity('Entry your First Name ?')"> </br>
                     <spna id="firstname"></spna>
               </div>
               <div class="col-md-6">

                  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required="required"> </br>
                  <spna id="lastname"></spna>
               </div>
            </div>

            <input type="text" class="form-control" id="company" name="company" placeholder="Company" required="required"> </br>

         </div>


         <div class="col-md-6"> 

            <input type="email" class="form-control" id="email" name="email"  placeholder="Email Address" required="required"> </br>

            <div class="row">
               <div class="col-md-4">
                  <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="phonenumber" name="phonenumber" placeholder="Phone Number" required="required"> </br>
               </div>

               <div class="col-md-4">
                  <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="mobilenumber" name="mobilenumber" placeholder="Mobile Number" required="required"> </br>
               </div>

               <div class="col-md-4">

                  <input type="text" class="form-control" id="website" name="website" placeholder="Website" required="required"> </br>
               </div> 

            </div>

         </div> 


         <h5> Address </h5>

         <div class="col-md-6"> 
            <p>Billing Address</p>

            <textarea class="form-control" rows="2" id="baddress" name="baddress" placeholder="Street Address" required="required"></textarea></br>

            <div class="row">
               <div class="col-md-6">   
               <input type="text" class="form-control" id="bcity" name="bcity" placeholder="City/Town" required="required"> </br>
               </div> 

               <div class="col-md-6"> <input type="text" class="form-control" id="bstate" name="bstate" 
                  placeholder="State/Province" required="required"></br>   </div>
                  <div class="col-md-6"> <input type="text" class="form-control" id="bpostalcode" name="bpostalcode" placeholder="Postal Code" onkeypress="return isNumberKey(event)" required="required"></br> </div>
                  <div class="col-md-6"> <input type="text" class="form-control" id="bcountry" name="bcountry" placeholder="Country" required="required"> </br> </div>

                     </div>


                  </div> 

                  <div class="col-md-6"> 

         <p> Shipping Address 
         <input type="checkbox" value="ongoing" name="Ongoing" id="ongoing" checked> 
         <span style="font-size:14px;">Same as billing address</span> 
         </p> 
         <textarea class="form-control" rows="2" id="shaddress" name="shaddress" placeholder="Street Address"></textarea></br>

         <div class="row">
            <div class="col-md-6">   
               <input type="text" class="form-control" id="shcity" name="shcity" placeholder="City/Town"> </br>
            </div> 

            <div class="col-md-6"> <input type="text" class="form-control" id="shstate" name="shstate" 
               placeholder="State/Province"></br>   </div>
               <div class="col-md-6"> <input type="text" class="form-control" id="shpostalcode" onkeypress="return isNumberKey(event)" name="shpostalcode" 
                  placeholder="Postal Code"></br> </div>
                  <div class="col-md-6"> <input type="text" class="form-control" id="shcountry" name="shcountry" 
                     placeholder="Country"> </br> </div>
                  </div>
               </div>   

               <h5> Notes </h5>

               <div class="row" style="float: left; margin-left:-1px; margin-bottom: 12px;">
                  <textarea class="form-control" rows="4" id="bnotes" name="bnotes" placeholder="Notes"></textarea></br></br>
               </div>  

               <h5> Tax Info </h5>

               <div class="row">

                  <div class="col-md-5"> 
                     <input type="text" class="form-control" required="required" id="taxinfo" name="taxinfo" placeholder="Tax Info"></br> </div>
                  </div>    

                  <!--<h5> Payment and Billing </h5>

                   <div class="row">

                     <div class="col-md-6"> 

                       <div class="row">   

                           <div class="col-md-6">
                            <p>Preferred payment method </p>  
                          
                           <select class="form-select" name="payment" id="payment" required="required" aria-label="Default select example">
                              <option selected>Payment Method</option>
                              <option value="Cash">Cash</option>
                              <option value="Cheque">Cheque</option>
                              <option value="Credit Card">Credit Card</option>
                              <option value="Direct Debit">Direct Debit</option>
                           </select>    

                          </br>   
                         </div>

                           <div class="col-md-6">  
                            <p>Preferred delivery method </p>    
                              
                           <select class="form-select" id="dmethod" name="dmethod" required="required" aria-label="Default select example">
                              <option selected>Delivery method</option>
                              <option value="Print Later">Print Later</option>
                              <option value="Send Later">Send Later</option>
                              <option value="None">None</option>
                           </select>    


                           </br>   </div>               


                        </div>   
                        

                     </div>   

                      <div class="col-md-6">  

                        <div class="row">

                           <div class="col-md-4">
                              <p>Terms </p>
                          <select class="form-select" id="duerecipt" required="required" name="duerecipt" aria-label="Default select example">
                              <option selected>Terms</option>
                              <option value="Due on recipt">Due on recipt</option>
                              <option value="Net 15">Net 15</option>
                              <option value="Net 30">Net 30</option>
                              <option value="Net 60">Net 60</option>
                           </select>  

                           </div>
                           <div class="col-md-4"> 
                              <p>Opening balance</p>
                              <input type="text" class="form-control" required="required" name="balance" id="balance"> </br>  
                            </div>  

                           <div class="col-md-4"> 
                                 
                               <p>As of</p>
                           <input type="date" class="form-control" name="cdate" required="required" id="cdate">  

                           </div>
                          
                        </div>   

                      </div>  

                  </div> -->

           </div> <!-- END The ROW -->

        </form>
         <div class="row" style="text-align:center;"> 
            <div id="message"></div>
            <span id="valida_error_message" style="color:red;"></span>
         </div>
           <button type="button" id="customer" class="btn btn-primary">Submit</button>

      <?php 
        }  
  
      }

