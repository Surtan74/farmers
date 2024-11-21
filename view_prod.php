<?php 
  include'admin/db_connect.php';
    $qry = $conn->query("SELECT * FROM  product_list where id = ".$_GET['id'])->fetch_array();
?>
<div class="container-fluid">

	<div class="card product-card">
        <img src="assets/img/<?php echo $qry['img_path'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title text-success"><?php echo $qry['name'] ?></h5>
          <p class="card-text truncate"><?php echo $qry['description'] ?></p>
          <div class="form-group">
          </div>
          <div class="row">
          	<div class="col-md-2"><label class="control-label text-success">Qty</label></div>
          	<div class="input-group col-md-7 mb-3">
			  <div class="input-group-prepend">
			    <button class="btn btn-outline-success" type="button" id="qty-minus"><span class="fa fa-minus"></button>
			  </div>
			  <input type="number" readonly value="1" min = 1 class="form-control text-center" name="qty" >
			  <div class="input-group-prepend">
			    <button class="btn btn-outline-success" type="button" id="qty-plus"><span class="fa fa-plus"></span></button>
			  </div>
			</div>
          </div>
          <div class="text-center">
          	<button class="btn btn-success btn-sm btn-block add-to-cart-btn" id="add_to_cart_modal"><i class="fa fa-cart-plus"></i> Add to Cart</button>
          </div>
        </div>
        
      </div>
</div>
<style>
	#uni_modal_right .modal-footer{
		display: none;
	}

    .product-card {
        transition: transform 0.3s ease;
        border: 2px solid #28a745;
        border-radius: 15px;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .card-img-top {
        transition: transform 0.5s ease;
    }

    .card-img-top:hover {
        transform: scale(1.05);
    }

    .btn-outline-success {
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
        transform: scale(1.1);
    }

    .add-to-cart-btn {
        transition: all 0.3s ease;
        background-color: #28a745;
        border-color: #28a745;
    }

    .add-to-cart-btn:hover {
        transform: scale(1.05);
        background-color: #218838;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.4);
    }

    .form-control {
        border-color: #28a745;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
</style>

<script>
	$('#qty-minus').click(function(){
		var qty = $('input[name="qty"]').val();
		if(qty == 1){
			return false;
		}else{
			$('input[name="qty"]').val(parseInt(qty) -1);
		}
	})
	$('#qty-plus').click(function(){
		var qty = $('input[name="qty"]').val();
			$('input[name="qty"]').val(parseInt(qty) +1);
	})
	$('#add_to_cart_modal').click(function(){
		$.ajax({
			url: 'admin/ajax.php?action=add_to_cart',
			method: 'POST',
			data: {
				pid: '<?php echo $_GET['id'] ?>', 
				qty: $('[name="qty"]').val()
			},
			success: function(resp){
				if(resp == 1) {
					alert_toast("Order successfully added to cart");
					$('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty"]').val()));
					$('.modal').modal('hide');
				} else {
					alert_toast("Error adding to cart", "error");
				}
			},
			error: function(err) {
				console.log(err);
				alert_toast("An error occurred", "error");
			}
		});
	})
</script>