<?php	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered


	// Echo out the field
?>
<table style="width:100%;">
<tbody>
<tr><td><label for="pickup_location">Pickup</label> </td><td><input title="Your pickup location" type="text" class="booking-places widefat" name="pickup_location" value="<?=@$pickup?>" /></td></tr>
<tr><td><label for="dropoff_location">Dropoff</label></td><td> <input title="Your dropoff location" type="text" class="booking-places widefat" name="dropoff_location" value="<?=@$dropoff?>"   /></td></tr>
<tr><td><label for="pickup_time">Pickup Date/Time</label> </td><td><input type="text" readonly="readonly" name="pickup_time" value="<?=@$time?>"  class=" datepicker widefat" /></td></tr>
<tr><td><label> <small>Vehicle</small></label></td><td>
<select name="vehicle"> 
<?php
if(isset($vehicle))
{
switch($vehicle)
{
case 'taxi':
echo @'<option value="taxi" selected> Taxi (1-4 People) </option> ';	
	break;
case 'van':
echo @'<option value="van" selected> Van (1-6 People) </option>';
	break;
}
}

?>
<option value="taxi"> Taxi (1-4 People) </option> 
<option value="van"> Van (1-6 People) </option> 
</select>

</td></tr>
<tr><td><label> <small>Payment Type</small></label></td><td>
<select name="payment_type"> 
<?php
if(isset($payment)):
switch($payment)
{
	case 'cash':
echo @'<option value="cash" selected> Cash </option> ';

case 'creditcard':
echo @'<option value="creditcard" selected> CreditCard </option> ';	
	break;
case 'prepay':
echo @'<option value="prepay" selected> PreyPay </option>';
	
	break;
}
endif;
?>
<option value="cash"> Cash </option> 
<option value="creditcard">  CreditCard </option> 
<option value="prepay">  PrePay </option> 
</select>
<?php
if($payment === "prepay")
{
	
?>
<a id="launchPrepay" href="#" class="btn btn-primary"><small>Click Here to PrePay</small></a>
<?php
	
}


?>
</td></tr>

<tr>
<td><label for="flight_number">Flight Number</label> </td>
<td>
<input name="flight_number" class="widefat" value="<?=@$flight_number?>" type="text"/>
</td>
</tr>
<tr>
<td><label for="flight_name">Flight Name</label> </td>
<td>
<input name="flight_name" class="widefat" type="text" value="<?=@$flight_name?>"/>
</td>
</tr>



<tr>
<td><label for="pickup_note">Notes</label> </td>
<td>
<textarea name="pickup_note"  class="widefat" >
<?=@$pickup_note?>
</textarea>
</td>
</tr>



</tbody>
</table>

