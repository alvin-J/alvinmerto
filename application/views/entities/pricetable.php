<table>
	<tr>
		<td> total </td>
		<td> <?php echo number_format($subtotal,2); ?> </td>
	</tr>
	<tr>
		<td> coupon </td>
		<td> 
			<?php
				if ($coupon == 0) {
					echo "<small id='addcoupon'> add </small>";
				} else {
					echo number_format($coupon,2); 		
				}
			 ?> 
		</td>
	</tr>
	<tr>
		<td> VAT(<?php echo $tax; ?>%) </td>
		<td> <?php echo number_format($taxval,2); ?> </td>
	</tr>
	<tr>
		<td colspan="2"> <small> TOTAL PAYABLE </small> <?php echo number_format($payable,2); ?> </td>
	</tr>
</table>
<center>
	<button id='paynow'> PROCEED PAYMENT </button>
</center>