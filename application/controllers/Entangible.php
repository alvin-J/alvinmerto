<?php
	
	class Entangible extends CI_controller {
		public function addcoupon() {
			$this->load->model("Mainprocs");

			$data 		= $this->input->post("data");

			$couponcode = $data['couponcode'];
			$grpid      = $this->session->userdata('sessionid');
			$custid 	= $this->Mainprocs->getUserIpAddr();
			
			$update = ["coupon" => $couponcode];
			$where  = ['grpid' => $grpid];

			$update = $this->Mainprocs->__update("saleshead",$update,$where);
			echo json_encode($update);
		}

		public function paying() {
			$this->load->model("Mainprocs");

			$data = $this->input->post("data");

			$grpid      = $this->session->userdata('sessionid');
			$custid 	= $this->Mainprocs->getUserIpAddr();

			$taxdets    = $this->Mainprocs->__getdata("vat","all");

			$tax = 0;
			if (count($taxdets) > 0) {
				$tax 		= $taxdets[0]->v_value;
			}

			$update = ["rectax"    => $tax,
					   "status"    => 0,
					   "cust_id"   => $custid,
					   "salesdate" => date("Y-m-d")];

			$where = ["grpid" => $grpid];

			$update = $this->Mainprocs->__update("saleshead",$update,$where);

			if ($update) {
				session_destroy();
				echo json_encode(true);
			}
		}

		public function removesales() {
			$salesid = $this->input->post("salesid");

			$this->load->model("Mainprocs");

			$sql 	= "delete from sales where salesid = '{$salesid}'";
			$delete = $this->Mainprocs->__run_q($sql);

			echo json_encode($delete);
		}
	}
?>