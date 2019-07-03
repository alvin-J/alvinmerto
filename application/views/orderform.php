<div class='main_table_wrap'>
	<div class='main_table'>
		<div class="row removepad_marg">
			<div class='col-md-9 removepadding'>
				<div class='theorders'>	
					<div class="row navigations removepad_marg">
						<?php
							if (count($cats) > 0) {
								foreach($cats as $c) {
									echo "<div class='col-md-4 cats' data-catid='{$c->catid}'>";
										echo $c->catname;
									echo "</div>";
								}
							}
						?>
					</div>

					<div id='content_wrapper'>
						
					</div>
				</div>
			</div>
			<div class='col-md-3 removepadding'>
				<div class='summary_list'>
					<div class='summaryheader'>
						<p class='head'> SUMMARY OF ORDERS </p>

						<div class='navigation uniformtbl'>
							<table>
								<thead>
									<tr>
										<th> NAME </th>
										<th> QTY </th>
										<th> PRICE </th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div id='listoforder' class='uniformtbl'>
						<table id='orderlist'> </table>
					</div>

					<div id='summary_foot'>
						<span id='pricetable'> </span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

