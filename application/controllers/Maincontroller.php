<?php
	
	class Maincontroller extends CI_Controller {
		public function index() {
			$data['title']					= "Main Page | ";
			$data['content'] 				= "orderform";
			$data['headscript']['js'][]   	= base_url()."js/entities.procs.js";
			
			$data['headscript']['style'][]  = base_url()."style/default.style.css"; 
			$data['headscript']['style'][]  = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"; 
			$data['headscript']['style'][]  = base_url()."style/global.style.css";

			$this->load->model("Mainprocs");

			// create session 
				$this->load->library('session');
				if ( NULL === $this->session->userdata("sessionid"))  {
					// no session
					$sid 	  = $this->Mainprocs->getUserIpAddr();
					$dtoday   = date("mdYHis");

					$usersess = ["sessionid" => $this->Mainprocs->createuniquenumber($sid.$dtoday,11)];
					$this->session->set_userdata($usersess);	
				}
			// end creating session

			$data['cats'] = $this->Mainprocs->__getdata("category","all");

			$this->load->view("includes/main",$data);
		}
	}
?>