<?php 
	class Mainprocs extends CI_Model {
		public function __getdata($table = false, $query , $where = false) {
			$this->load->database();

			$sql = null;

			if ($table != false) {
				// not yet tested in the workfield
					$sql = "SELECT ";
					if ( is_array($query) ) {
						$count = 0;
						foreach($query as $q) {
							$sql .= $q;
							$sql .= ($count == count($query)-1)?"":",";
							$count++;
						}
					} else if ($query == "all") {
						$sql .= "* ";
					}

					$sql .= " from {$table}";

					if ($where != false && is_array($where)) {
						$sql .= " WHERE ";
						$count = 0;
						foreach($where as $key => $value) {
							$sql .= $key ."='".$value."'";
							$sql .= ($count==count($where)-1)?"":" AND ";
							$count++;
						}
					}
				// end
			} else {
				$sql = $query;
			}
	
			$query = $this->db->query($sql);
			$ret   = $query->result();
			$this->db->close();
			return $ret;
		}

		public function __update($table, $values, $where = false) {
			$this->load->database();

			$sql = null;

			if ( is_array($values) ) {
				$count = 0;
				$sql = "update {$table} set ";

				foreach($values as $field => $vals) {
					$sql .= $field ."='".$vals."'";
					$sql .= ($count == count($values)-1)?"":",";
					$count++;
				}

				if ($where != "false" || $where != false) {
					if (!is_array($where)) {
						return false;
					} else {
						$count = 0;
						$sql .= " WHERE ";
						foreach($where as $field => $val) {
							if ($field != "connector") {
								$sql .= $field ."='".$val."' ";
								//$sql .= ($count == count($where)-1)?"":"";
							} else {
								$sql .= $val." ";
							}
						}
					}
				}
			}

			$ret = $this->db->query($sql);
			$this->db->close();
			return $ret;
		}

		public function __store($table, $values) {
			$this->load->database();
			
			$sql  = null;

			if (is_array($values)) {
				$count = 0;
				$sql = "insert into {$table} (";
				
				foreach(array_keys($values) as $a) {
					$sql .= $a;
					$sql .= ($count == count($values)-1)?"":",";
					$count++;
				}

				$sql .= ") VALUES (";
				$count = 0;
				
				foreach($values as $vals) {
					$sql .= "'".$vals."'";
					$sql .= ($count == count($values)-1)?"":",";
					$count++;
				}	
				$sql .= ")";
				
			} else {
				$sql = $values;
			}

			$ret = $this->db->query($sql);
			$this->db->close();
			return $ret;
		}

		public function __run_q($sql) {
			$this->load->database();

			$ret = $this->db->query($sql);
			$this->db->close();
			return $ret;
		}


		public function __datetoday() {
			// __datetoday is base from local time of server 
			return date("Y-m-d");
		}

		public function createuniquenumber($word,$length = false) {
			if ($length > strlen(md5($word)) || $length == false) {
				$length = 11;
			}
			return substr(md5(substr(md5($word),0,$length).substr(md5($this->__datetoday().date("His")),0,$length)),0,$length);
		}

		public function sendemail($details) {
			$this->load->library('email');
 
			$config = array();
			$config['protocol']  = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.googlemail.com';
			$config['smtp_user'] = 'anwenglish.noreply@gmail.com';
			$config['smtp_pass'] = 'ghty56ruei';
			$config['smtp_port'] = 465;
			$config['mailtype']  = 'html';
    		$config['charset']   = 'iso-8859-1';
			$this->email->initialize($config);
			 
			$this->email->set_newline("\r\n");

			$this->email->from("anwenglish@noreply", $details['from_msg']);
	        $this->email->to($details['to']);
	        $this->email->subject($details['subject']);
	        $this->email->message($details['msg']);

	        if($this->email->send()) {
	        	return true;
	        } else {
            	return false;
	        }
		}

		public function secure() {
			$type = $this->session->userdata("type");
			if ($type != 3) {
				redirect(base_url(),"refresh");
			}
		}

		function getUserIpAddr(){
			$ip = null;
		    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		        //ip from share internet
		        $ip = $_SERVER['HTTP_CLIENT_IP'];
		    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		        //ip pass from proxy
		        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    }else{
		        $ip = $_SERVER['REMOTE_ADDR'];
		    }
		    return $ip;
		}

		

	}	
?>