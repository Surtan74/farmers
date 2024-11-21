<!-- Masthead -->
<header class="masthead text-white" style="background: linear-gradient(135deg, #2d5a27 0%, #3a7233 100%); padding: 160px 0;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
               <p class="text-center" style="font-size: 3.5em; font-weight: 600; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); margin-bottom: 30px;">Welcome to our Agricultural Store</p>
                <hr class="divider my-4" style="width: 60px; border-width: 3px; border-color: #fff;" />
                <a class="btn btn-success btn-xl js-scroll-trigger" href="#menu" style="font-size: 1.2em; padding: 15px 40px; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s ease;">Shop Now</a>
            </div>
        </div>
    </div>
</header>

<!-- About Section -->
<section class="page-section bg-white" id="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <h2 class="display-4 fw-bold" style="color: #2d5a27">About Us</h2>
                <div class="divider-custom">
                    <div class="divider-custom-line" style="width: 50px; height: 3px; background: #3a7233; margin: 1rem auto;"></div>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
                    <div class="card-body p-5">
                        <p class="lead text-muted mb-4" style="line-height: 1.8;">
                            <?php echo htmlspecialchars($_SESSION['setting_description'] ?? 'Welcome to our agricultural store. We are committed to providing the best products to support your farming needs. Our range includes high-quality seeds, fertilizers, tools, and more. Join us in nurturing the growth of your farm and achieving bountiful harvests.'); ?>
                        </p>
                        
                        <div class="row g-4 mt-4">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check-circle text-success fa-2x me-3"></i>
                                    <h6 class="mb-0">Premium Quality Products</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check-circle text-success fa-2x me-3"></i>
                                    <h6 class="mb-0">Sustainable Solutions</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check-circle text-success fa-2x me-3"></i>
                                    <h6 class="mb-0">Expert Support</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="page-section bg-light" id="features">
    <div class="container">
        <h2 class="text-center " style="font-size:2.5em"><b>Why Choose Us</b></h2>
        <div class="d-flex justify-content-center">
            <hr class="divider border-success" width="10%">
        </div>
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="feature-box text-center p-4 border rounded shadow-sm h-100">
                    <i class="fa fa-leaf fa-3x text-success mb-3"></i>
                    <h5>Organic Products</h5>
                    <p>We offer a wide range of organic products that promote sustainable farming practices.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box text-center p-4 border rounded shadow-sm h-100">
                    <i class="fa fa-shield-alt fa-3x text-success mb-3"></i>
                    <h5>Quality Assurance</h5>
                    <p>All our products undergo strict quality checks to ensure the best for your farm.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-box text-center p-4 border rounded shadow-sm h-100">
                    <i class="fa fa-truck fa-3x text-success mb-3"></i>
                    <h5>Fast Delivery</h5>
                    <p>We ensure timely delivery of your orders right to your doorstep.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Section -->
<section class="page-section bg-light" id="menu">
    <div class="container">
        <h1 class="text-center " style="font-size:3em"><b>Our Products</b></h1>
        <div class="d-flex justify-content-center">
            <hr class="divider border-success" width="5%">
        </div>
        <div id="menu-field" class="row mt-4">
            <?php 
                include 'admin/db_connect.php';
                $limit = 10;
                $page = (isset($_GET['_page']) && $_GET['_page'] > 0) ? intval($_GET['_page']) - 1 : 0;
                $offset = $page * $limit;
                $all_menu = $conn->query("SELECT id FROM product_list")->num_rows;
                $page_btn_count = ceil($all_menu / $limit);
                $qry = $conn->query("SELECT * FROM product_list ORDER BY `name` ASC LIMIT $limit OFFSET $offset");
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
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="w-100 d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <!-- Previous Page Button -->
                    <li class="page-item <?php echo ($page == 0) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="./?_page=<?php echo ($page > 0) ? ($page) : '#'; ?>">Prev</a>
                    </li>

                    <!-- Page Buttons -->
                    <?php for($i = 1; $i <= $page_btn_count; $i++): ?>
                        <?php if($page_btn_count > 10): ?>
                            <?php if($i == $page_btn_count && !in_array($i, range(($page - 3), ($page + 3)))): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>

                            <?php if($i == 1 || $i == $page_btn_count || in_array($i, range(($page - 3), ($page + 3)))): ?>
                                <li class="page-item <?php echo ($i == ($page + 1)) ? 'active' : ''; ?>">
                                    <a class="page-link" href="./?_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php if($i == 1 && !in_array($i, range(($page - 3), ($page + 3)))): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="page-item <?php echo ($i == ($page + 1)) ? 'active' : ''; ?>">
                                <a class="page-link" href="./?_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Next Page Button -->
                    <li class="page-item <?php echo (($page + 1) == $page_btn_count) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="./?_page=<?php echo ($page + 2); ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="page-section bg-white" id="testimonials">
    <div class="container">
        <h2 class="text-center" style="font-size:2.5em"><b>What Our Customers Say</b></h2>
        <div class="d-flex justify-content-center">
            <hr class="divider border-success" width="10%">
        </div>
        <div id="testimonial-carousel" class="carousel slide mt-4" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="testimonial text-center p-4 border rounded shadow-sm">
                                <img src="assets/img/customer1.jpg" alt="Customer 1" class="rounded-circle mb-3" width="80" height="80">
                                <h5>Mike Maina</h5>
                                <p>"Excellent quality products and outstanding customer service. Highly recommend!"</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="testimonial text-center p-4 border rounded shadow-sm">
                                <img src="assets/img/customer2.jpg" alt="Customer 2" class="rounded-circle mb-3" width="80" height="80">
                                <h5>Jane Maria</h5>
                                <p>"The variety of products available has greatly improved my farming practices."</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="testimonial text-center p-4 border rounded shadow-sm">
                                <img src="assets/img/customer3.jpg" alt="Customer 3" class="rounded-circle mb-3" width="80" height="80">
                                <h5>Esther Wambui</h5>
                                <p>"Fast delivery and reliable support. Couldn't ask for more!"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Controls -->
            <a class="carousel-control-prev" href="#testimonial-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-success rounded-circle p-3" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#testimonial-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-success rounded-circle p-3" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Signup Section -->
<section class="page-section bg-light" id="newsletter">
    <div class="container text-center">
        <h2 style="font-size:2.5em"><b>Subscribe to Our Newsletter</b></h2>
        <p class="mt-3">Stay updated with our latest products and offers.</p>
        <form class="form-inline justify-content-center mt-4">
            <div class="form-group mb-2">
                <label for="newsletter-email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="newsletter-email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn btn-success mb-2 ml-2">Subscribe</button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="bg-success text-white py-4">
    <div class="container text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($_SESSION['setting_name']); ?>. All rights reserved.</p>
        <div class="social-icons mt-2">
            <a href="#" class="text-white mr-3"><i class="fab fa-facebook-f fa-lg"></i></a>
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

        // Add to cart functionality for direct button
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

        // Add to cart functionality for modal button
        $(document).on('click', '#add_to_cart_modal', function(){
            $.ajax({
                url: 'admin/ajax.php?action=add_to_cart',
                method: 'POST',
                data: {
                    pid: '<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>', 
                    qty: $('[name="qty"]').val()
                },
                success: function(resp){
                    if(resp == 1) {
                        alert_toast("Product successfully added to cart");
                        $('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty"]').val()));
                        $('.modal').modal('hide');
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
    });

    <?php if(isset($_GET['_page'])): ?>
    $(function(){
        $('html, body').animate({
            scrollTop: $('#menu').offset().top - 100
        }, 600);
    });
    <?php endif; ?>

    // Initialize Testimonial Carousel with Autoplay
    $(document).ready(function(){
        $('#testimonial-carousel').carousel({
            interval: 5000,
            ride: 'carousel'
        });
    });
</script>

<!-- Custom Styles -->
<style>
    /* Masthead Background */
    .masthead.bg-agriculture {
        background-image: url('assets/img/agriculture-header.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Overlay on Card Images */
    .card .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(40, 167, 69, 0.7);
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

    /* Testimonial Styling */
    .testimonial img {
        border: 3px solid #28a745;
    }

    .testimonial p {
        font-style: italic;
    }

    /* Newsletter Form Styling */
    #newsletter .form-control {
        width: 300px;
    }

    /* Animation for Cards */
    .feature-animation {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .feature-animation.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* Scroll Reveal Animations */
    @media (prefers-reduced-motion: no-preference) {
        .page-section {
            transition: opacity 1s ease-out, transform 1s ease-out;
            opacity: 0;
            transform: translateY(20px);
        }

        .page-section.show {
            opacity: 1;
            transform: translateY(0);
        }
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

        // Add Animation Class to Cards
        const cards = document.querySelectorAll('.feature-animation');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('show');
            }, index * 100);
        });
    });
</script>
