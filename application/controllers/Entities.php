<?php 
	
	class Entities extends CI_Controller {

		function loadprods() {
			$catid = $this->input->post("catid");

			$this->load->model("Mainprocs");

			$data['prods'] = $this->Mainprocs->__getdata("listofprods","all",["category"=>$catid]);

			$this->load->view("entities/products",$data);
		}

		public function addproduct() {
			$data = $this->input->post("dets");

			$this->load->model("Mainprocs");

			$ip = $this->Mainprocs->getUserIpAddr();

			// get data regarding the product 
				$prod_data = $this->Mainprocs->__getdata("listofprods","all",["prod_id"=>$data['proid']]);
				if (count($prod_data) == 0) {
					return;
				}		
			// end 

			// groud id
				$grpid = $this->session->userdata('sessionid');
			// end 

			// sales id 
				$salesid = $this->Mainprocs->createuniquenumber($grpid.date("mdYHisu"),11);
			// end 
			$values = ["salesid"		=> $salesid,
					   "prodid" 		=> $data['proid'],
					   "qty"    		=> $data['prod_qty'],
					   "rec_price"      => $prod_data[0]->price,
					   "status"    		=> 1,
					   "groupid"    	=> $grpid];

			$add = $this->Mainprocs->__store("sales",$values);

			$html = null;
			$d['sales'] = [];
			if ($add) {
				$name    = $prod_data[0]->prodname;
				$qty 	 = $data['prod_qty'];
				$subtot  = $prod_data[0]->price*$data['prod_qty'];

				array_push($d['sales'],["name" => $name, "qty" => $qty , "subtot" => $subtot, "salesid" => $salesid]);
				$html = $this->load->view("entities/orderlist",$d,true);
			}
			echo $html;
		}

		public function computetotal() {
			$this->load->model("Mainprocs");
			$this->load->model("Compute");

			$grpid = $this->session->userdata('sessionid');

			// compute
			$products = $this->Mainprocs->__getdata("sales","all",["groupid"=>$grpid,"status"=>1]);
			$deducts  = $this->Mainprocs->__getdata("saleshead","all",["grpid"=>$grpid,"status"=>1]);

			if (count($deducts) == 0){return;}
			if (count($products) == 0) { return 0; }

			// get the current tax
				$tax = $deducts[0]->rectax;
				if ($deducts[0]->rectax == "null" || $deducts[0]->rectax == null) {
					$tax_data 	= $this->Mainprocs->__getdata("vat","all");
					$rectax = 0;
					if (count($tax_data) > 0) {
						$tax   = $tax_data[0]->v_value;
					}
				}
			// end 

			$tax      = $tax/100;

			// get the subtotal
				foreach($products as $ps) {
					$price_x_qty = $ps->rec_price*$ps->qty;
					array_push($this->Compute->values,$price_x_qty);
				}

				$this->Compute->ops = "+";
				$this->Compute->process();
					
				$total = $this->Compute->result();
			// end getting sub total

			// get the value for coupon
				$coupon   = 0; // $deducts[0]->coupon; // 0 is the default value

				if ( strcmp($deducts[0]->coupon,0) != 0) {
					$coupon_dets = $this->Mainprocs->__getdata("coupon",'all',['cid'=>$deducts[0]->coupon,"status"=>1]);
					
					if (count($coupon_dets) > 0) { 
						$coupon = $coupon_dets[0]->discountprice;

						if (strcmp($coupon_dets[0]->discounttype,"percentage") == 0){ // equal
							$d 		= $coupon_dets[0]->discountprice/100;
							$coupon = $total*$d;
						}
					} 
				} 
			// end coupon

			// tax value
				$tax_value = $total*$tax;
			// end tax value

				// compute the total payable with tax
					$this->Compute->values = [$total,$tax_value];
					$this->Compute->ops    = "+";
					$this->Compute->process();
					$payable = $this->Compute->result();
				// end 

				// deduct the coupon code 
					$this->Compute->values = [$payable,$coupon];
					$this->Compute->ops    = "-";
					$this->Compute->process();
					$payable = $this->Compute->result();
				// end 

			// setting the variables
			$data['subtotal'] = $total;
			
			$data['coupon']   = $coupon;

			$data['tax']	  = $tax*100;
			$data['taxval']   = $tax_value;

			$data['payable']  = $payable;

			$this->load->view("entities/pricetable",$data);
		}

		public function getorders() {
			// retrieve possible data from the database 
				$this->load->model("Mainprocs");
				$grpid =  $this->session->userdata('sessionid');

				$sql   = "select s.*, lp.prodname from sales as s 
								join listofprods as lp on 
							lp.prod_id = s.prodid 
								where s.groupid = '{$grpid}'
							and s.status = '1'";

				$sales = $this->Mainprocs->__getdata(false,$sql);

				$data['sales'] = [];
				if (count($sales) ==0){ return; }
				foreach($sales as $s) {
					$salesid = $s->salesid;
					$price   = $s->rec_price;
					$name    = $s->prodname;
					$qty     = $s->qty;
					$subtot  = $price*$qty;
					array_push($data['sales'],["name" => $name, "qty" => $qty , "subtot" => $subtot, "salesid" => $salesid]);
				}

				$html = $this->load->view("entities/orderlist",$data,true);
				echo $html;
			// end
		}
	}

?>