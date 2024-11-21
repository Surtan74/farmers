<?php 
include 'admin/db_connect.php';

// Fetch about content securely
$about_content = $_SESSION['setting_about_content'] ?? '<p>Welcome to our agricultural store. We are dedicated to providing the best products to support your farming needs.</p>';
?>
<!-- Masthead -->
<header class="masthead text-white" style="background: linear-gradient(135deg, #2d5a27 0%, #3a7233 100%);">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <p class="display-4" style="font-family: 'Dancing Script', !important; font-size: 4em !important;">About Us</p>
                <hr class="divider my-4 bg-light" />
                <p class="lead">Learn more about our mission, vision, and the team behind our success.</p>
            </div>
        </div>
    </div>
</header>

<!-- About Section -->
<section class="page-section bg-white py-5" id="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <hr class="divider border-success" style="width: 10%;">
                        </div>
                        <div class="about-content">
                            <?php echo html_entity_decode($about_content); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="page-section bg-light py-5" id="mission-vision">
    <div class="container">
        <h2 class="text-center  mb-4"><b>Our Mission & Vision</b></h2>
        <div class="row">
            <!-- Mission -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 feature-box text-center p-4">
                    <i class="fa fa-bullseye fa-3x text-success mb-3"></i>
                    <h5>Our Mission</h5>
                    <p>To provide high-quality agricultural products that empower farmers to achieve sustainable and profitable farming.</p>
                </div>
            </div>
            <!-- Vision -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 feature-box text-center p-4">
                    <i class="fa fa-binoculars fa-3x text-success mb-3"></i>
                    <h5>Our Vision</h5>
                    <p>To be the leading agricultural store recognized for excellence, innovation, and commitment to the farming community.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
<section class="page-section bg-white py-5" id="team">
    <div class="container">
        <h2 class="text-center  mb-4"><b>Meet Our Team</b></h2>
        <div class="d-flex justify-content-center">
            <hr class="divider border-success" width="10%">
        </div>
        <div class="row mt-4">
            <!-- Team Member 1 -->
            <div class="col-md-4 mb-4">
                <!-- add this image kwa assets folder  -->
                <div class="card h-100 team-member shadow-sm">
                    <img src="assets/img/team_member1.jpg" 
                    
                    class="card-img-top" alt="Team Member 1">
                    <div class="card-body text-center">
                        <h5 class="card-title">Collins</h5>
                        <p class="card-text">Founder & CEO</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 team-member shadow-sm">
                    <img src="assets/img/team_member2.jpg" class="card-img-top" alt="Team Member 2">
                    <div class="card-body text-center">
                        <h5 class="card-title">patner</h5>
                        <p class="card-text">Head of Operations</p>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="page-section bg-light py-5" id="values">
    <div class="container">
        <h2 class="text-center  mb-4"><b>Our Values</b></h2>
        <div class="d-flex justify-content-center">
            <hr class="divider border-success" width="10%">
        </div>
        <div class="row mt-4">
            <!-- Value 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 feature-box text-center p-4">
                    <i class="fa fa-seedling fa-3x text-success mb-3"></i>
                    <h5>Quality</h5>
                    <p>Committed to providing only the best products that meet our high standards.</p>
                </div>
            </div>
            <!-- Value 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 feature-box text-center p-4">
                    <i class="fa fa-handshake fa-3x text-success mb-3"></i>
                    <h5>Integrity</h5>
                    <p>Operating with honesty and transparency in all our interactions.</p>
                </div>
            </div>
            <!-- Value 3 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 feature-box text-center p-4">
                    <i class="fa fa-leaf fa-3x text-success mb-3"></i>
                    <h5>Sustainability</h5>
                    <p>Promoting sustainable farming practices for a better future.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-success text-white py-4">
    <div class="container text-center">
        <p>&copy; <?= date("Y") ?> <?= htmlspecialchars($_SESSION['setting_name']) ?>. All rights reserved.</p>
        <div class="social-icons mt-2">
            <a href="<?= htmlspecialchars($_SESSION['facebook_link'] ?? '#') ?>" class="text-white mr-3"><i class="fab fa-facebook-f fa-lg"></i></a>
            <a href="<?= htmlspecialchars($_SESSION['twitter_link'] ?? '#') ?>" class="text-white mr-3"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="<?= htmlspecialchars($_SESSION['instagram_link'] ?? '#') ?>" class="text-white mr-3"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="<?= htmlspecialchars($_SESSION['linkedin_link'] ?? '#') ?>" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
        </div>
    </div>
</footer>

<!-- Custom Styles -->
<style>
    /* Masthead Styling */
    .masthead.bg-about {
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

    /* Feature Box Styling */
    .feature-box {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .feature-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Team Member Card Styling */
    .team-member img {
        height: 250px;
        object-fit: cover;
    }

    /* Truncate Text */
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Card Hover Effects */
    .card-body {
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .card-body:hover {
        background-color: #f1f1f1;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Responsive Image */
    .img-fluid {
        max-height: 350px;
    }

    /* Social Icons Styling */
    .social-icons a {
        transition: color 0.3s;
    }

    .social-icons a:hover {
        color: #d4d4d4;
    }

    /* Section Headings */
    .text-cursive {
        font-family: 'Dancing Script', ;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .masthead.bg-about {
            padding: 100px 0;
        }

        .team-member img {
            height: 200px;
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
    });
</script>