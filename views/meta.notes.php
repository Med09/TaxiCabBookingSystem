<div class="payment">
<label>How will you pay</label>
<select>
<?php	
global $post;
    $payment = get_post_meta($post->ID, 'payment_type', true);
    print_r($payment);

echo @'<option name="'.$payment.'" selected>'.$payment.'</option>'

?>

<option name="cash">cash</option>
<option name="creditcard">creditcard</option>
<option name="prepay">preypay</option>
</select>



<style>
label {display:block;}
</style>
 <form class="booking-prepay" action="/create_transaction" method="POST" id="braintree-payment-form">
 <table>
 <tr><td><label>Amount $ </label><input name="amount" type="text" size="20" autocomplete="off" data-encrypted-name="number" /></td></tr>
 <tr><td><label>Card Number</label><input name="number" type="text"  autocomplete="off" data-encrypted-name="number" /><input type="text" size="5"  placeholder="CVV" name="CVV" autocomplete="off" data-encrypted-name="cvv" /></td></tr>
 

 <tr><td><label>Expiration (MM/YYYY)</label><input name="epirationDate" type="text"  placeholder="month MM" data-encrypted-name="month" /><input type="text" placeholder="Year YYYY" size="4" data-encrypted-name="year" /></td></tr>
 <tr><td>         	 	 <div id="facebookG">
<div id="blockG_1" class="facebook_blockG">
</div>
<div id="blockG_2" class="facebook_blockG">
</div>
<div id="blockG_3" class="facebook_blockG">
</div>
</div>	 


<a id="schedule" style="width:100px; text-align:center;" class="primary button  block submit-pay">Pre Pay</a>
         </td></tr>
 
 </table>
     

      </form>
      </div>
      
 