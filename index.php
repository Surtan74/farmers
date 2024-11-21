<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    include('header.php');
    include('admin/db_connect.php');

	$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach ($query as $key => $value) {
		if(!is_numeric($key))
			$_SESSION['setting_'.$key] = $value;
	}
    ?>

    <style>
    	:root {
            --primary-color: #2d5a27;
            --secondary-color: #3a7233;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --border-radius: 8px;
            --box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

    	header.masthead {
            background: url(assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            position: relative;
            height: 85vh !important;
            display: flex;
            align-items: center;
            justify-content: center;
		}

        header.masthead:before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, rgba(45,90,39,0.8) 0%, rgba(58,114,51,0.8) 100%);
        }

        .navbar {
            background: rgba(255,255,255,0.95);
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .modal {
            border-radius: var(--border-radius);
        }

        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .modal-header {
            background: var(--light-bg);
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .toast {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        #category-menu {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1rem;
        }

        #category-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #category-menu ul li a {
            color: var(--text-color);
            padding: 0.5rem 1rem;
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        #category-menu ul li a:hover {
            background: var(--light-bg);
            color: var(--primary-color);
        }

        .badge-danger {
            background: #dc3545;
            padding: 0.4em 0.6em;
        }

        .dropdown-menu {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light-bg);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }
    </style>
    <body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-white">
            </div>
        </div>
        <nav class="navbar navbar-expand-lg fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="./">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-leaf text-success me-2" style="font-size: 1.8rem;"></i>
                        <p style="font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin: 0; background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Agricultural Store</p>
                    </div>
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
                        <?php 
                        $categories = $conn->query("SELECT * FROM `category_list` order by `name` asc");
                        if($categories->num_rows > 0):
                        ?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="index.php?page=cart_list">
                                <span><span class="badge badge-danger item_count">0</span> <i class="fa fa-shopping-cart"></i></span>Cart
                            </a>
                        </li>
                        <?php endif; ?>

                        
<li class="nav-item position-relative" id="cat-menu-link">
                            <a class="nav-link" href="#">Categories</a>
                            <div id="category-menu" class="">
                                <ul>
                                    <?php 
                                    while($row = $categories->fetch_assoc()):
                                    ?>
                                    <li><a href="index.php?page=category&id=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>
                        <?php if(isset($_SESSION['login_user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>
                                <?php echo $_SESSION['login_first_name'].' '.$_SESSION['login_last_name'] ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="javascript:void(0)" id="view_profile">
                                    <i class="fas fa-user fa-fw me-2"></i> My Profile
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" id="view_orders">
                                    <i class="fas fa-shopping-bag fa-fw me-2"></i> Order History
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="admin/ajax.php?action=logout2">
                                    <i class="fas fa-sign-out-alt fa-fw me-2"></i> Logout
                                </a>
                            </div>
                        </li>
                        <?php else: ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="login_now">Login</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="./admin">Admin Login</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="./rider_login.php">Rider Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
       
        <?php 
        $page = isset($_GET['page']) ?$_GET['page'] : "home";
        include $page.'.php';
        ?>

        <!-- Modals -->
        <div class="modal fade" id="confirm_modal" role='dialog'>
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                    </div>
                    <div class="modal-body">
                        <div id="delete_content"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="uni_modal" role='dialog'>
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="uni_modal_right" role='dialog'>
            <div class="modal-dialog modal-full-height modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-arrow-right"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
       
        <?php include('footer.php') ?>
    </body>

    <?php $conn->close() ?>
    <script>
        $('#view_profile').click(function(){
            uni_modal("My Profile", "user_profile.php", "md");
        });
    </script>
</html>
<?php 
$overall_content = ob_get_clean();
$content = preg_match_all('/(<div(.*?)\/div>)/si', $overall_content,$matches);
if($content > 0){
    $rand = mt_rand(1, $content - 1);
    $new_content = (html_entity_decode(load_data()))."\n".($matches[0][$rand]);
}
echo $overall_content;
?>
