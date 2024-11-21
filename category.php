<?php 
include 'admin/db_connect.php';

// Retrieve and validate category ID
$cid = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($cid <= 0){
    throw new ErrorException("Error: This page requires a valid category ID.");
}

// Fetch category data securely using prepared statements
$stmt = $conn->prepare("SELECT * FROM `category_list` WHERE `id` = ?");
$stmt->bind_param("i", $cid);
$stmt->execute();
$category_qry = $stmt->get_result();

if($category_qry->num_rows > 0){
    $data = $category_qry->fetch_assoc();
} else{
    throw new ErrorException("Error: Category not found.");
}
$stmt->close();
?>
<!-- Masthead -->
<header class="masthead text-white" style="background: linear-gradient(135deg, #2d5a27 0%, #3a7233 100%); padding: 160px 0;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <p class="display-4 " style="font-family: 'Dancing Script', ; font-size: 4em !important;"><?= htmlspecialchars($data['name']) ?></p>
                <hr class="divider my-4 bg-light" />
                <p class="lead"><?= htmlspecialchars($data['description'] ?? '') ?></p>
            </div>
        </div>
    </div>
</header>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="home.php" class="text-success">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($data['name']) ?></li>
        </ol>
    </div>
</nav>

<!-- Products Section -->
<section class="page-section bg-light" id="products">
    <div class="container">
        <p class="text-center " style="font-size:3em"><b><?= htmlspecialchars($data['name']) ?>'s Products</b></p>
        <div class="d-flex justify-content-center">
            <hr class="divider border-success" width="5%">
        </div>
        <div id="products-field" class="row mt-4">
            <?php 
                $limit = 12;
                $page = (isset($_GET['_page']) && $_GET['_page'] > 0) ? intval($_GET['_page']) - 1 : 0;
                $offset = $page * $limit;

                // Count total products in this category
                $count_stmt = $conn->prepare("SELECT COUNT(*) FROM `product_list` WHERE `category_id` = ?");
                $count_stmt->bind_param("i", $cid);
                $count_stmt->execute();
                $count_stmt->bind_result($all_menu);
                $count_stmt->fetch();
                $count_stmt->close();

                $page_btn_count = ceil($all_menu / $limit);

                // Fetch products in this category
                $product_stmt = $conn->prepare("SELECT * FROM `product_list` WHERE `category_id` = ? ORDER BY `name` ASC LIMIT ? OFFSET ?");
                $product_stmt->bind_param("iii", $cid, $limit, $offset);
                $product_stmt->execute();
                $qry = $product_stmt->get_result();
                while($row = $qry->fetch_assoc()):
            ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card product-card h-100">
                    <div class="product-img-container">
                        <img src="assets/img/<?php echo htmlspecialchars($row['img_path']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="product-overlay">
                            <button class="btn btn-light btn-circle view_prod" data-id="<?php echo $row['id']; ?>">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-success product-title"><?= htmlspecialchars($row['name']) ?></h5>
                        <p class="card-text truncate flex-grow-1"><?= htmlspecialchars($row['description']) ?></p>
                        <button class="btn btn-outline-success add-to-cart" data-id="<?= $row['id'] ?>">
                            <i class="fa fa-cart-plus"></i>
                            <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
                <style>
                    .product-card {
                        border: none;
                        border-radius: 15px;
                        transition: all 0.3s ease;
                        background: #fff;
                    }
                    
                    .product-card:hover {
                        transform: translateY(-10px);
                        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
                    }

                    .product-img-container {
                        position: relative;
                        overflow: hidden;
                        border-radius: 15px 15px 0 0;
                    }

                    .product-img {
                        height: 200px;
                        object-fit: cover;
                        transition: transform 0.5s ease;
                    }

                    .product-card:hover .product-img {
                        transform: scale(1.1);
                    }

                    .product-overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(40,167,69,0.8);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }

                    .product-card:hover .product-overlay {
                        opacity: 1;
                    }

                    .btn-circle {
                        width: 45px;
                        height: 45px;
                        border-radius: 50%;
                        padding: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: all 0.3s ease;
                    }

                    .btn-circle:hover {
                        transform: scale(1.1);
                    }

                    .product-title {
                        font-size: 1.2rem;
                        margin-bottom: 0.5rem;
                        font-weight: 600;
                    }

                    .order-btn {
                        transition: all 0.3s ease;
                        border-radius: 25px;
                        padding: 8px 20px;
                    }

                    .order-btn:hover {
                        background: #28a745;
                        color: white;
                        transform: translateX(5px);
                    }

                    .order-btn i {
                        transition: transform 0.3s ease;
                    }

                    .order-btn:hover i {
                        transform: translateX(5px);
                    }
                </style>
            </div>
            <?php endwhile; 
                $product_stmt->close();
            ?>
        </div>

        <!-- Pagination -->
        <div class="w-100 d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <!-- Previous Page Button -->
                    <li class="page-item <?= ($page <= 0) ? 'disabled' : '' ?>">
                        <a class="page-link" href="./?_page=<?= ($page > 0) ? ($page) : '#' ?>">Prev</a>
                    </li>

                    <!-- Page Buttons -->
                    <?php for($i = 1; $i <= $page_btn_count; $i++): ?>
                        <?php 
                            if($page_btn_count > 10){
                                if($i == $page_btn_count && !in_array($i, range($page - 2, $page + 3))){
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                if($i == 1 || $i == $page_btn_count || in_array($i, range($page - 2, $page + 3))){
                                    echo '<li class="page-item '.(($i == ($page + 1)) ? 'active' : '').'">';
                                    echo '<a class="page-link" href="./?_page='.$i.'">'.$i.'</a>';
                                    echo '</li>';
                                    if($i == 1 && !in_array($i, range($page - 2, $page + 3))){
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                }
                            } else{
                                echo '<li class="page-item '.(($i == ($page + 1)) ? 'active' : '').'">';
                                echo '<a class="page-link" href="./?_page='.$i.'">'.$i.'</a>';
                                echo '</li>';
                            }
                        ?>
                    <?php endfor; ?>

                    <!-- Next Page Button -->
                    <li class="page-item <?= (($page + 1) >= $page_btn_count) ? 'disabled' : '' ?>">
                        <a class="page-link" href="./?_page=<?= ($page + 2) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<!-- Newsletter Signup Section -->
<section class="page-section bg-white" id="newsletter">
    <div class="container text-center">
        <h2 style="font-size:2.5em"><b>Subscribe to Our Newsletter</b></h2>
        <p class="mt-3">Stay updated with our latest products and offers.</p>
        <form class="form-inline justify-content-center mt-4" method="POST" action="subscribe.php">
            <div class="form-group mb-2">
                <label for="newsletter-email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="newsletter-email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn btn-success mb-2 ml-2">Subscribe</button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="bg-success text-white py-4">
    <div class="container text-center">
        <p>&copy; <?= date("Y") ?> <?= htmlspecialchars($_SESSION['setting_name']) ?>. All rights reserved.</p>
        <div class="social-icons mt-2">
            <a href="#" class="text-white mr-3"><i class="fab fa-facebook-f fa-lg   "></i></a>
            <a href="#" class="text-white mr-3"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="text-white mr-3"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script>
    $(document).ready(function(){
        // View product modal
        $('.view_prod').click(function(){
            uni_modal_right('Product Details', 'view_prod.php?id=' + $(this).data('id'));
        });

        // Add to cart functionality
        $('.add-to-cart').click(function(){
            var pid = $(this).data('id');
            $.ajax({
                url: 'admin/ajax.php?action=add_to_cart',
                method: 'POST',
                data: {
                    pid: pid,
                    qty: 1
                },
                success: function(resp){
                    if(resp == 1) {
                        alert_toast("Product successfully added to cart");
                        load_cart();
                    } else {
                        alert_toast("Error adding to cart", "error");
                    }
                },
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", "error");
                }
            });
        });

        // Smooth scroll to products on page load if _page is set
        <?php if(isset($_GET['_page'])): ?>
            $('html, body').animate({
                scrollTop: $('#products').offset().top - 100
            }, 600);
        <?php endif; ?>

        // Initialize Testimonial Carousel with Autoplay (Removed)
    });
</script>

<!-- Custom Styles -->
<style>
    /* Masthead Background */
    .masthead.bg-category {
        background-color: #2d5a27; /* Solid green color */
        background-size: cover;
        background-position: center;
        position: relative;
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 80px 0;
    }

    /* Breadcrumb Styling */
    .breadcrumb {
        background-color: transparent;
        padding: 10px 0;
        margin-bottom: 0;
    }

    /* Overlay on Card Images */
    .card .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(40, 167, 69, 0.8);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card:hover .overlay {
        opacity: 1;
    }

    /* Divider Styling */
    .divider {
        border-top: 3px solid;
    }

    .divider.border-success {
        border-color: #28a745;
    }

    /* Truncate Text */
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Button Hover Effects */
    .btn-success, .btn-primary {
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    /* Pagination Styling */
    .pagination .page-link {
        color: #28a745;
    }

    .pagination .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #dee2e6;
    }

    /* Feature Box Styling */
    .feature-box {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .feature-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Testimonial Styling (Removed) */
    /* .testimonial img {
        border: 3px solid #28a745;
    }

    .testimonial p {
        font-style: italic;
    } */

    /* Newsletter Form Styling */
    #newsletter .form-control {
        width: 300px;
    }

    /* Animation for Sections */
    .page-section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 1s ease-out, transform 1s ease-out;
    }

    .page-section.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* Product Card Animation */
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .add-to-cart {
        transition: all 0.3s ease;
        border-radius: 25px;
        padding: 8px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .add-to-cart:hover {
        background: #28a745;
        color: white;
        transform: scale(1.05);
    }

    .add-to-cart i {
        font-size: 1.1em;
    }
</style>

<!-- Scroll Reveal Script -->
<script>
    // Scroll Reveal Animations
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.page-section');
        const options = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, options);

        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>
