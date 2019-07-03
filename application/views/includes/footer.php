</div> <!-- end of the big wrapper -->
		     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
		<script src='<?php echo base_url(); ?>/js/vars.js'></script>
		
    	<?php 
	        if (isset($headscript) && isset($headscript['js'])) {
	            foreach($headscript['js'] as $st) {
	                echo "<script src='".$st."'></script>";
	            }
	        }
    	?>

</body>

</html>