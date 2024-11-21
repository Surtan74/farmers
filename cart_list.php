<?php 
include 'admin/db_connect.php';

// Retrieve user identifier
if(isset($_SESSION['login_user_id'])){
    $data = "WHERE c.user_id = ?";
    $params = [$_SESSION['login_user_id']];
    $types = "i";
} else {
    $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $data = "WHERE c.client_ip = ?";
    $params = [$ip];
    $types = "s";
}

$total = 0;

// Prepare and execute the cart query securely
$stmt = $conn->prepare("SELECT c.id AS cid, p.id AS pid, p.name, p.description, p.price, p.img_path, c.qty 
                        FROM cart c 
                        INNER JOIN product_list p ON p.id = c.product_id 
                        $data");
$stmt->bind_param($types, ...$params);
$stmt->execute();
$get = $stmt->get_result();
?>
<!-- Masthead -->
<header class="masthead text-white" style="background: linear-gradient(135deg, #2d5a27 0%, #3a7233 100%); padding: 160px 0;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <p class="display-4" style="font-family: 'Dancing Script', !important; font-size: 4em !important;">Shopping Cart</p>
                <hr class="divider my-4 bg-light" />
            </div>
        </div>
    </div>
</header>

<!-- Cart Section -->
<section class="page-section bg-light" id="cart">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row font-weight-bold">
                            <div class="col-md-6">Items</div>
                            <div class="col-md-6 text-right">Total</div>
                        </div>
                    </div>
                </div>
                <?php while($row = $get->fetch_assoc()): 
                    $total += ($row['qty'] * $row['price']);
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Item Details -->
                            <div class="col-md-4 d-flex align-items-center">
                                <!-- Remove Button -->
                                <a href="admin/ajax.php?action=delete_cart&id=<?= $row['cid'] ?>" class="rem_cart btn btn-sm btn-outline-danger mr-3" data-id="<?= $row['cid'] ?>" title="Remove Item">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <!-- Product Image -->
                                <img src="assets/img/<?= htmlspecialchars($row['img_path']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-fluid rounded" style="max-width: 80px; max-height: 80px;">
                            </div>
                            <!-- Product Information -->
                            <div class="col-md-4">
                                <h5 class="mb-1"><?= htmlspecialchars($row['name']) ?></h5>
                                <p class="text-muted mb-1 truncate"><?= htmlspecialchars($row['description']) ?></p>
                                <p class="mb-1"><strong>Unit Price:</strong>ksh<?= number_format($row['price'], 2) ?></p>
                                <!-- Quantity Controls -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary qty-minus" type="button" data-id="<?= $row['cid'] ?>"><i class="fa fa-minus"></i></button>
                                    </div>
                                    <input type="number" readonly value="<?= $row['qty'] ?>" min="1" class="form-control text-center" name="qty">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary qty-plus" type="button" data-id="<?= $row['cid'] ?>"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Price -->
                            <div class="col-md-4 text-right">
                                <h5>ksh<?= number_format($row['qty'] * $row['price'], 2) ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; 
                    $stmt->close();
                ?>
            </div>
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <hr>
                        <p class="card-text"><strong>Total Amount:</strong> <span class="float-right">ksh<?= number_format($total, 2) ?></span></p>
                        <hr>
                        <button class="btn btn-success btn-block" type="button" id="checkout">
                            <i class="fa fa-credit-card"></i> Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
    /* Masthead Styling */
    .masthead.bg-cart {
        background-color: #3a7233; /* Solid green background */
        padding: 160px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    /* Divider Styling */
    .divider {
        border-top: 3px solid;
    }

    .divider.bg-light {
        border-color: #f8f9fa;
    }

    /* Truncate Text */
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Button Hover Effects */
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Quantity Input Styling */
    .input-group .form-control {
        max-width: 60px;
    }

    /* Sticky Sidebar */
    .sticky-top {
        top: 100px;
    }

    /* Responsive Image */
    .card img {
        width: auto;
        height: auto;
    }

    /* Cart Item Card Styling */
    .card-body {
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .card-body:hover {
        background-color: #f1f1f1;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Order Summary Card */
    .card-title {
        font-size: 1.5em;
    }

    .float-right {
        float: right;
    }

    /* Button Icons */
    #checkout i {
        margin-right: 8px;
    }
</style>

<!-- Scripts -->
<script>
    $(document).ready(function(){
        // View Product Modal
        $('.view_prod').click(function(){
            uni_modal_right('Product Details', 'view_prod.php?id='+$(this).data('id'))
        });

        // Quantity Minus Button
        $('.qty-minus').click(function(){
            var cid = $(this).data('id');
            var qtyInput = $(this).closest('.input-group').find('input[name="qty"]');
            var qty = parseInt(qtyInput.val()) - 1;
            if(qty < 1) qty = 1;
            qtyInput.val(qty);
            update_qty(qty, cid);
        });

        // Quantity Plus Button
        $('.qty-plus').click(function(){
            var cid = $(this).data('id');
            var qtyInput = $(this).closest('.input-group').find('input[name="qty"]');
            var qty = parseInt(qtyInput.val()) + 1;
            qtyInput.val(qty);
            update_qty(qty, cid);
        });

        // Update Quantity via AJAX
        function update_qty(qty, id){
            $.ajax({
                url: 'admin/ajax.php?action=update_cart_qty',
                method: "POST",
                data: {id: id, qty: qty},
                success: function(resp){
                    if(resp == 1){
                        load_cart();
                    } else {
                        alert("Failed to update quantity.");
                    }
                },
                error: function(){
                    alert("An error occurred while updating the quantity.");
                }
            });
        }

        // Remove Cart Item via AJAX
        $('.rem_cart').click(function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            if(confirm("Are you sure you want to remove this item from your cart?")){
                window.location.href = href;
            }
        });

        // Proceed to Checkout
        $('#checkout').click(function(){
            <?php if(isset($_SESSION['login_user_id'])): ?>
                window.location.href = "index.php?page=checkout";
            <?php else: ?>
                uni_modal("Checkout", "login.php?page=checkout");
            <?php endif; ?>
        });
    });
</script>
