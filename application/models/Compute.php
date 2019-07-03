<?php 
	
	class Compute extends CI_Model {
		public $values  = [];
		public $ops     = null;

		private $result = 0;

		public function process() {
			if (count($this->values) == 0) return;

			$loc_res = 0;
			$count   = 0;
			foreach($this->values as $vs) {
				switch($this->ops) {
					case "+": $loc_res = $loc_res+$vs;  break;
					case "-": 
							if ($count == 0) {
								$loc_res = $vs;
								break;
							} else {
								$loc_res = $loc_res-$vs;		
							}
						break;
					case "*": $loc_res = $loc_res*$vs;  break;
					case "/": $loc_res = $loc_res/$vs;  break;
				}
				$count++;
				$this->result = $loc_res;
// 				echo "hello=".$this->result."<br/>";
			}
			return true;
		}

		public function result() {
			return $this->result;
		}		
	}

?>