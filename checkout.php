<?php
include 'admin/db_connect.php';
session_start();

// Redirect if user is not logged in
if(!isset($_SESSION['login_user_id'])){
    echo "<script>alert('Please login to proceed to checkout.'); location.replace('./index.php?page=login');</script>";
    exit;
}

// Check if the cart is empty
$chk = $conn->query("SELECT * FROM cart WHERE user_id = {$_SESSION['login_user_id']}")->num_rows;
if($chk <= 0){
    echo "<script>alert('You don\'t have any items in your cart yet.'); location.replace('./index.php?page=home');</script>";
    exit;
}

// Fetch user information
$first_name = htmlspecialchars($_SESSION['login_first_name'] ?? '');
$last_name = htmlspecialchars($_SESSION['login_last_name'] ?? '');
$mobile = htmlspecialchars($_SESSION['login_mobile'] ?? '');
$address = htmlspecialchars($_SESSION['login_address'] ?? '');
$email = htmlspecialchars($_SESSION['login_email'] ?? '');
?>
<!-- Masthead -->
<header class="masthead text-white" style="background: linear-gradient(135deg, #2d5a27 0%, #3a7233 100%); padding: 160px 0;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <p class="display-4" style="font-family: 'Dancing Script', !important; font-size: 4em !important;">Checkout</p>
                <hr class="divider my-4 bg-light" style="width: 10%; margin: 1rem auto;"/>
            </div>
        </div>
    </div>
</header>

<!-- Checkout Section -->
<section class="page-section bg-light py-5" id="checkout">
    <div class="container">
        <div class="row">
            <!-- Delivery Information Form -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">Confirm Delivery Information</h4>
                        <form action="" id="checkout-frm">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name" class="control-label">First Name</label>
                                    <input type="text" name="first_name" id="first_name" required class="form-control" value="<?php echo $first_name; ?>" placeholder="Enter your first name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" required class="form-control" value="<?php echo $last_name; ?>" placeholder="Enter your last name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="control-label">Contact Number</label>
                                <input type="text" name="mobile" id="mobile" required class="form-control" value="<?php echo $mobile; ?>" placeholder="Enter your contact number">
                            </div>
                            <div class="form-group">
                                <label for="address" class="control-label">Address</label>
                                <textarea name="address" id="address" cols="30" rows="3" required class="form-control" placeholder="Enter your delivery address"><?php echo $address; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" name="email" id="email" required class="form-control" value="<?php echo $email; ?>" placeholder="Enter your email address">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-block btn-lg">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch cart items
                        $stmt = $conn->prepare("SELECT p.name, p.price, c.qty FROM cart c INNER JOIN product_list p ON p.id = c.product_id WHERE c.user_id = ?");
                        $stmt->bind_param("i", $_SESSION['login_user_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $total = 0;
                        while($row = $result->fetch_assoc()):
                            $subtotal = $row['price'] * $row['qty'];
                            $total += $subtotal;
                        ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo htmlspecialchars($row['name']); ?> x <?php echo $row['qty']; ?></span>
                            <span>ksh<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <?php endwhile; ?>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>ksh<?php echo number_format($total, 2); ?></strong>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-block btn-outline-dark">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
    /* Masthead Styling */
    .masthead.bg-checkout {
        background-color: #2d5a27; /* Solid green background */
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

    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
    }

    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .card-title {
        font-family: 'Dancing Script', cursive;
        font-size: 2em;
        color: #2d5a27;
    }

    /* Form Labels */
    .form-group label {
        font-weight: bold;
        color: #2d5a27;
    }

    /* Input Fields */
    .form-control {
        border-radius: 10px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

    /* Button Styling */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-outline-dark {
        color: #2d5a27;
        border-color: #2d5a27;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-outline-dark:hover {
        background-color: #2d5a27;
        color: #fff;
    }

    /* Order Summary Styling */
    .card-header.bg-success {
        background-color: #2d5a27 !important;
    }

    .card-header.bg-success h5 {
        font-size: 1.25em;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .masthead.bg-checkout {
            padding: 100px 0;
        }

        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }

        .btn-lg {
            font-size: 1em;
        }
    }

    /* Hover Effects */
    .card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        transition: box-shadow 0.3s ease-in-out;
    }

    /* Truncate Text */
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Smooth Scroll for Proceed to Payment */
    .btn-outline-dark {
        cursor: pointer;
    }
</style>

<!-- Scripts -->
<script>
    $(document).ready(function(){
        $('#checkout-frm').submit(function(e){
            e.preventDefault();
            $('.btn-success').attr('disabled', true).text('Placing Order...');

            // Remove existing error messages
            if($(this).find('.alert-danger').length > 0 )
                $(this).find('.alert-danger').remove();
            
            $.ajax({
                url:"admin/ajax.php?action=save_order",
                method:'POST',
                data:$(this).serialize(),
                error: function(err){
                    console.log(err);
                    $('.btn-success').removeAttr('disabled').text('Place Order');
                    alert("An error occurred while placing your order. Please try again.");
                },
                success:function(resp){
                    if(resp==1){
                        alert_toast("Order successfully Placed.");
                        setTimeout(function(){
                            location.replace('index.php?page=home');
                        },1500);
                    } else{
                        $('#checkout-frm').prepend('<div class="alert alert-danger">An error occurred while placing your order. Please try again.</div>');
                        $('.btn-success').removeAttr('disabled').text('Place Order');
                    }
                }
            });
        });
    });
</script>