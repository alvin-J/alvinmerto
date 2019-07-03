function entities() {
	var ent = new Object();

	this.computetheprice = function() {
		$(document).find("#pricetable").html("computing...")
			.load(host+"Entities/computetotal", function(){

			})
	}

	this.appendtoorders = function(html) {
		$(document).find("#orderlist").prepend(html);
	}

	this.__start = function() {
		$(document).on("click",".cats",function(){

			$(this).addClass("selectedcat").siblings().removeClass("selectedcat")

			ent.catid = $(this).data("catid");
			$(document).find("#content_wrapper").html("loading...")
				.load(host+"Entities/loadprods",{ catid : ent.catid },function(){

				})
		})

		$(document).on("click","#content_wrapper ul li",function(){
			ent.proid = $(this).data("proid");

			$(this).css("width","550px").siblings().removeAttr("style");
		})

		$(document).on("click",".addbtn",function(){
			ent.prod_qty = $(document).find("#_qty_"+ent.proid).val();
			
			if (ent.prod_qty == "undefined" || ent.prod_qty == undefined || ent.prod_qty.length == 0) {
				alert("Product Quantity cannot be empty"); return;
			}

			$.ajax({
				url 		: host+"/Entities/addproduct",
				type 		: "post",
				data 		: { dets : ent },
				dataType    : "html",
				success     : function(data) {
					e.appendtoorders(data);
					e.computetheprice();

					e.resetvariable();
				}, error    : function() {
					alert("error on adding of products")
				}
			})
		})

		$(document).on("click","#addcoupon",function(){
			$("<div>",{ class : "blacker" , id : "black" }).on("click",function(e){
				if (e.target.id == 'black') {
					$(this).fadeOut("fast",function(){
						$(this).remove();
					})
				}
			}).append("<div class='innerblack'> <p> ADD COUPON CODE </p> <input type='text' id='ccode'/> <button class='btn btn-primary' id='addcouponbtn'> add coupon </button></div>")
					.appendTo(document.body);
		
			// add coupon btn 
				$(document).on("click","#addcouponbtn",function(){
					ent.couponcode = $(document).find("#ccode").val();

					$.ajax({
						url 		: host+"Entangible/addcoupon",
						type    	: "post",
						data 		: { data : ent },
						dataType 	: "json",
						success 	: function(data){
							if (data) {
								$(document).find("#black").fadeOut("fast",function(){
									$(document).find("#black").remove();
								})
								e.computetheprice();
							}
						}, error    : function() {
							alert("Error on adding coupon code")
						}
					})
				})
			// end 

		})

		$(document).on("click",".voidtr",function(){
			var conf 	= confirm("Are you sure?");

			if (!conf) { return; }
			var salesid = $(this).data("salesid"),
				thiss   = $(this);

			$.ajax({
				url 		: host+"Entangible/removesales",
				type 		: "post",
				data 		: { salesid : salesid },
				dataType    : "json",
				success     : function(data) {
					thiss.remove();
					e.computetheprice();
				}, error    : function() {
					alert("error removing order")
				}
			})
		})

		$(document).on("click","#paynow",function(){
			$.ajax({
				url 	 : host+"Entangible/paying",
				type 	 : "post",
				data 	 : { data : ent },
				dataType : "json",
				success  : function(data){
					if (data){
						alert("Thank you for your patronage... come again")
						window.location.reload();
					}
				},error  : function() {
					alert("error on paying...")
				}
			})
		})

		// display products 
			e.getorders();
		// end 
	}

	this.resetvariable = function() {
		ent = new Object();
	}

	this.getorders = function() {
		$.ajax({
			url 	 : host+"Entities/getorders",
			type     : "post",
			data     : {},
			dataType : "html",
			success  : function(html){
				e.appendtoorders(html);
				e.computetheprice();
			}, error : function(){
				alert("error on displaying products")
			}
		})
	}
}

var e = new entities();
	e.__start();