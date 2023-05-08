  <?php 
  if ( ! defined('ABSPATH')) exit;  // if direct access 

  /**
  *  Estimate
  */
  require 'itr_estimate_db.php';
  //require 'customer_show.php';

  final class add_estimate{


    function __construct(){

      new itr_dbestimate();
      add_shortcode('itr_estimate', [$this, 'itr_add_estimate']);  

    } 

    public function itr_add_estimate(){
      ?> 

      <div class="row"> 
       <div class="col-md-12"><h3>Estimate</h3></div>
     </div>

     <div class="row">
       <div class="col-md-5"> 
         <input type="button" id="itr_invoice" name="itr_invoice" value="Create Invoice"> 
         <span id="estimate"></span>
       </div>

     </div> 
     <form method="POST" action="">
       <div class="row"> 
        <div class="col-md-2 itr_estimate_title"> 
          Estimate no.
        </div>
        <div class="col-md-2 itr_estimate_title">

          <input type="text" class="form-control estimate_number" id="estmateno" name="estmateno" disabled readonly>  

        </div>

      </div> 

      <div class="row"> 
       <div class="col-md-3"> 
        <span> Customer</span>
        <select class="form-control" name="itr_customer" id="itr_customer">
         <option selected>--Select--</option>
      
          </select>

          </div>

          <div class="col-md-3">
            <span>Email</span>
            <input type="text" class="form-control" id="cemail" name="cemail" disabled required>
    
          </div>

          <div class="col-md-3 itr_invrow">  <!-- onclick="itrgenerateInvoiceNumber()" -->

          </div>

          <div class="col-md-3"> 
            <span class="text-end">Amount</span>
            <input type="number" id="itramount" name='itramount'  placeholder='0.00' class="form-control" readonly/>

          </div>

        </div>

        <br>

        <div class="row">
          <!-- <div class="col-md-3"> <span>Estimate Status</span> 
            <select class="form-control" name="itrestimate" id="itrestimate">
              <option selected>--Select--</option>
              <option value="Pending">Pending</option>
              <option value="Accepted">Accepted</option>
              <option value="Closed">Closed</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div> -->
          <div class="col-md-9">   

            <div id="itrpending" style="display:none;"></div>

            <div id="itraccept" style="display:none;">

             <div class="row">  
               <div class="col-md-3"> 
                <span>By</span>
                <input type="text" id="itrstatusby" name='itrstatusby' class="form-control"/>  
              </div>
              <div class="col-md-3"> <span>Date</span> 
                <input type="Date" id="itrstatusdate" name='itrstatusdate' class="form-control"/>            
              </div>
            </div>
          </div>

          <div id="itrclose" style="display:none;">
            <div class="row">  
             <div class="col-md-3"> 
               <span>By</span>
               <input type="text" id="itrstatusby" name='itrstatusby' class="form-control"/>
             </div>
             <div class="col-md-3"> 
               <span>Date</span>  
               <input type="Date" id="itrstatusdate" name='itrstatusdate' class="form-control"/>
             </div> 
           </div>
         </div> 

         <div id="itrrejected" style="display:none;">
          <div class="row">  
           <div class="col-md-3"> <span>By</span> 
             <input type="text" id="itrstatusby" name='itrstatusby' class="form-control"/> 
           </div>
           <div class="col-md-3"> <span>Date</span>  
             <input type="Date" id="itrstatusdate" name='itrstatusdate' class="form-control"/>  
           </div>   
         </div>
       </div>

     </div> <!-- end the estimate -->
   </div> 

   <!-- <div class="itrestimate_div clearfix"> sssssss </div> -->
   <br> <br>
   <div class="row">

    <div class="col-md-3"> 
     <span>Billing Address</span>
     <textarea class="form-control" id="caddress" name="caddress" rows="3"></textarea>
   </div>
   <div class="col-md-2"> 
     <span>Estimate date</span>
     <input type="date" class="form-control" name="bdate" required="required" id="bdate">  
   </div>
   <div class="col-md-2">

     <span>Expiration date</span>
     <input type="date" class="form-control" name="epdate" required="required" id="epdate">  
   </div>
 </div> 


 <div class="row esti-table"> 
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="itrtab_logic">
          <thead>
            <tr>
              <!-- <th class="text-center"> # </th> -->
              <th class="text-center"> Product </th>
              <th class="text-center"> Desciption </th>
              <th class="text-center"> Qty </th>
              <th class="text-center"> Price </th>
              <th class="text-center"> Total </th>
            </tr>
          </thead>
          

          <tbody>

           <tr id='itraddr0' class="griditems" itemindex="0">
            <td><input type="text" name='product[]' id="product0" placeholder='Enter Product Name' class="form-control"/></td>

            <td><input type="text" name='description[]' id="description0" placeholder='Enter Description Name' class="form-control"/></td>

            <td><input type="text" name='qty[]' onkeypress="return isNumberKey(event)" id="qty0" placeholder='Enter Qty' class="form-control qty" step="0" min="0"/></td>
            <td><input type="text" name='price[]' onkeypress="return isNumberKey(event)" id="price0" placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/></td>
            <td><input type="text" name='total[]' id="total0" placeholder='00' class="form-control total" readonly/></td>
          </tr>
          
        </tbody>



      </table>
    </div>
  </div>


  <div class="row clearfix">
    <div class="col-md-12">  
      <div id="itradd_row">Add Row</div>
      <div id="itrdelete_row">Delete Row</div>
    </div>
  </div>

  <div class="row clearfix" >
    <div class="row">
      <div class="col-md-7"> </div>
      <div class="col-md-2 itrsub">Sub Total</div>
      <div class="col-md-3"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/> </div>
    </div>  

    <div class="row clearfix" style="margin-top:20px">
      <div class="col-md-7"> </div>
      <div class="col-md-2"> </div>
      <div class="col-md-3"> 
        <div id="valida_error_message"></div>


      </div>
    </div> 

    <div class="row clearfix" style="margin-top:20px">

      <div class="col-md-4"> 
        <span>Message displayed on estimate</span>
        <textarea class="form-control" id="itr_est_message" name="itr_est_message" rows="3"></textarea>
      </div>
      <div class="col-md-4"></div>
      <div class="col-md-4"></div>

    </div> 

    <div class="row clearfix" style="margin-top:20px">

      <div class="col-md-4"> 
        <span>Message displayed on statement</span>
        <textarea class="form-control" id="itr_state_message" name="itr_state_message" rows="3"></textarea>
      </div>
      <div class="col-md-4">
        
         <div id="emessage"></div>
         <span id="error_message" style="color:red;"></span>

      </div>
      <div class="col-md-4">  

       <button type="button" id="addestimate" name="addestimate" class="btn btn-primary">Add Estimate</button> 

     </div>
   </div>  
  </div> 
 </div>
</div> 	

</form>

     <!-- ==============  estimate script =============  -->








<?php
}

}  /*end the class*/



