<div id="existingcustomer" class="booking-modal">
<form name="existingcustomer"> 
<table>
<tr><td><label>Phone Number</label><input name="phone" maxlength="10" type="number"/></td><td><label>PIN</label><input name="pin" min="1" max="9999"  type="number"/></td></tr>
<tr><td><input name="action" value="existingcustomer" type="hidden"/></td></tr>
<tr><td><a href="#" class="submit-booking btn">Submit</a></td></tr>
</table>
<div class="response">
<pre>
</pre>
</div>
</form>

</div>


<div id="newcustomer" class="booking-modal">
<form name="newcustomer">

   
      
<table>
<tr><td><label>First Name</label><input name="firstname" type="text"/></td><td><label>First Name</label><input name="lastname" type="text"/></td></tr>
<tr><td>
<small>
Attn: International Clients
Please add your area code as well. 
USA: 6500000000
India: 919800098000
</small>

</td>
<td>
<small>
You will use your phone and pin to login and manage your bookings.

</small>

</td>

</tr>
<tr><td><label>Phone Number</label><input name="phone" maxlength="10" type="number"/></td><td><label>PIN</label><input name="pin"  min="1" max="9999" type="number"//></td></tr>
<tr><td><label>Email</label><input name="email" type="text"/></td><td><label>Pickup Note</label><input type="text" name="pickup_note"/></td></tr>
<tr><td><input name="action" value="newcustomer" type="hidden"/></td></tr>
<tr><td><a href="#" class="submit-booking btn">Submit</a></td></tr>
</table>
<div class="response">
<pre>
</pre>
</div>
</form>

</div>





<div id="prepay" class="booking-modal">
<form>
 <table>
  <tr><td><label>Card Number</label> <input type="text" size="20" name="creditCard" autocomplete="off" value="5105105105105100" data-encrypted-name="number" /></td><td><label>CVV</label><input name="cvv" type="text" size="4" autocomplete="off" value="123" data-encrypted-name="cvv" /></td></tr>
  <tr><td><label>Expiration Month</label> <input type="text" size="2" name="expirationMonth"  maxlength="2" value="10" placeholder="MM"data-encrypted-name="month" /></td><td><label>Year</label><input maxlength="4"  placeholder="YYYY" type="text" size="4" name="expirationYear" value="2015" data-encrypted-name="year" /></td></tr>
<tr><td><label>Estimated Fare</label> <input type="number" name="amount" id="amount" size="2" /></td><td style="text-align:center"><a href="#" class="submit-prepay btn">Prepay</a></td></tr>
  
      </table>
      <div class="response">
      <small>Save this prepay receipt</small>
      <pre>
      
      </pre>
      </div>
      </form>
      <a href="#prepay" id="showPrepay" style="display:none" rel="leanModal"></a>
      </div>