<?php 
	if (count($prods) > 0) {
		echo "<ul>";
			foreach($prods as $p) {
				echo "<li data-proid='{$p->prod_id}'>";
					echo "<div class='row rowrow removepad_marg'>";
						echo "<div class='col-md-3 removepadding thepic'>";
							$url = base_url()."/{$p->pic}";
							echo "<div class='picframe' style='background-image:url($url); background-size:cover;'>";
								// echo "<img src='".base_url()."/{$p->pic}'/>";
							echo "</div>";
						echo "</div>";
						echo "<div class='col-md-9 removepadding detailsdiv'>";
							echo "<p class='prdname'>".$p->prodname."</p>";
							echo "<table>";
								echo "<tr>";
									echo "<th> PRICE </th>";
									echo "<th> QTY </th>";
									echo "<th> &nbsp; </th>";
								echo "</tr>";
								echo "<tr>";
									echo "<td> {$p->price} </td>";
									echo "<td> <input type='text' class='qtyinput' id='_qty_{$p->prod_id}'/> </td>";
									echo "<td> <button class='addbtn'> ADD </button> </td>";
								echo "</tr>";
							echo "</table>";
						echo "</div>";
					echo "</div>";
					
				echo "</li>";
			}
		echo "</ul>";
	}
?>