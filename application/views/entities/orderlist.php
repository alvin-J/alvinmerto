<?php foreach($sales as $s) { ?>
<tr class='voidtr' data-salesid = '<?php echo $s['salesid']; ?>'> 
	<td> <?php echo $s['name']; ?> </td>
	<td> <?php echo $s['qty']; ?> </td>
	<td> <?php echo $s['subtot']; ?> </td>
</tr>
<?php } ?>
