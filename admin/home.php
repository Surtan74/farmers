<?php
require_once("./db_connect.php");
session_start();

// Fetch user information securely
$login_name = htmlspecialchars($_SESSION['login_name'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Menu Styling */
        .custom-menu {
            z-index: 1000;
            position: absolute;
            background-color: #ffffff;
            border: 1px solid #0000001c;
            border-radius: 5px;
            padding: 8px;
            min-width: 13vw;
        }

        a.custom-menu-list {
            width: 100%;
            display: flex;
            color: #4c4b4b;
            font-weight: 600;
            font-size: 1em;
            padding: 8px 12px;
            text-decoration: none;
        }

        a.custom-menu-list span.icon {
            width: 1em;
            margin-right: 10px;
        }

        a.custom-menu-list:hover {
            background: #80808024;
            border-radius: 3px;
        }

        /* Candidate Styling */
        .candidate {
            margin: auto;
            width: 23vw;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 1em;
            display: flex;
            border: 3px solid #00000008;
            background: #8080801a;
            position: relative;
        }

        .candidate_name {
            margin: 8px 20px;
            width: 100%;
        }

        .img-field {
            display: flex;
            height: 8vh;
            width: 4.3vw;
            padding: 0.3em;
            background: #80808047;
            border-radius: 50%;
            position: absolute;
            left: -0.7em;
            top: -0.7em;
        }

        .candidate img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
        }

        .vote-field {
            position: absolute;
            right: 0;
            bottom: -0.4em;
        }

        /* Image Holder Styling */
        #img-holder {
            width: 100%;
            height: 45vh;
            overflow: hidden;
            border-radius: 15px;
        }

        #img-holder>img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            object-position: center center;
        }

        /* Card and Icon Styling */
        span.card-icon {
            position: absolute;
            font-size: 3em;
            bottom: 0.2em;
            color: #ffffff80;
        }

        /* Table Styling */
        table th,
        table td {
            /* Customize table borders if needed */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .candidate {
                width: 90vw;
            }

            #img-holder {
                height: 30vh;
            }
        }

        .card {
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .badge {
            padding: 0.5em 1em;
            border-radius: 50px;
        }
        
        .btn-light {
            background: rgba(255,255,255,0.9);
            border: none;
        }
        
        .btn-light:hover {
            background: #fff;
        }
        
        .table th {
            background: #f8f9fa;
        }
        
        .bg-success {
            background-color: #2d5a27 !important;
        }
        
        .text-success {
            color: #2d5a27 !important;
        }
        
        .border-success {
            border-color: #2d5a27 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Welcome Message -->
        <div class="row mt-4 mb-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4>Welcome back, <?php echo $login_name; ?>!</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Active Menu -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card text-success border-success h-100">
                    <div class="card-body position-relative">
                        <i class="fa fa-th-list fa-3x position-absolute top-0 end-0 mt-2 me-2 text-success opacity-25"></i>
                        <h5 class="card-title">Total Active Menu</h5>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `product_list` WHERE `status` = 1");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $menu_a = $result['total'] ?? 0;
                        ?>
                        <h2 class="card-text"><?php echo number_format($menu_a); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Inactive Menu -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card text-danger border-danger h-100">
                    <div class="card-body position-relative">
                        <i class="fa fa-ban fa-3x position-absolute top-0 end-0 mt-2 me-2 text-danger opacity-25"></i>
                        <h5 class="card-title">Total Inactive Menu</h5>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `product_list` WHERE `status` = 0");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $menu_i = $result['total'] ?? 0;
                        ?>
                        <h2 class="card-text"><?php echo number_format($menu_i); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Orders for Verification -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card text-warning border-warning h-100">
                    <div class="card-body position-relative">
                        <i class="fa fa-hourglass-half fa-3x position-absolute top-0 end-0 mt-2 me-2 text-warning opacity-25"></i>
                        <h5 class="card-title">Orders for Verification</h5>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE `status` = 0");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $o_fv = $result['total'] ?? 0;
                        ?>
                        <h2 class="card-text"><?php echo number_format($o_fv); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Confirmed Orders -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card text-primary border-primary h-100">
                    <div class="card-body position-relative">
                        <i class="fa fa-check-circle fa-3x position-absolute top-0 end-0 mt-2 me-2 text-primary opacity-25"></i>
                        <h5 class="card-title">Confirmed Orders</h5>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE `status` = 1");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $o_c = $result['total'] ?? 0;
                        ?>
                        <h2 class="card-text"><?php echo number_format($o_c); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Active Riders Card -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card text-success border-success h-100">
                    <div class="card-body position-relative">
                        <i class="fa fa-motorcycle fa-3x position-absolute top-0 end-0 mt-2 me-2 text-success opacity-25"></i>
                        <h5 class="card-title">Active Riders</h5>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `riders` WHERE `status` = 1");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $active_riders = $result['total'] ?? 0;
                        ?>
                        <h2 class="card-text"><?php echo number_format($active_riders); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Pending Deliveries Card -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card text-warning border-warning h-100">
                    <div class="card-body position-relative">
                        <i class="fa fa-clock fa-3x position-absolute top-0 end-0 mt-2 me-2 text-warning opacity-25"></i>
                        <h5 class="card-title">Pending Deliveries</h5>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `orders` WHERE `delivery_status` = 'pending'");
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $pending_deliveries = $result['total'] ?? 0;
                        ?>
                        <h2 class="card-text"><?php echo number_format($pending_deliveries); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Riders Management Section -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riders Management</h5>
                        <button class="btn btn-light btn-sm" onclick="window.location.href='index.php?page=riders'">
                            <i class="fa fa-plus"></i> Manage Riders
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Active Deliveries</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $riders = $conn->query("SELECT r.*, 
                                        (SELECT COUNT(*) FROM orders WHERE rider_id = r.rider_id AND delivery_status = 'assigned') as active_deliveries 
                                        FROM riders r ORDER BY status DESC, name ASC LIMIT 5");
                                    while($row = $riders->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']) ?></td>
                                        <td><?php echo htmlspecialchars($row['phone']) ?></td>
                                        <td>
                                            <?php if($row['status'] == 1): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?php echo $row['active_deliveries'] ?> orders
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="window.location.href='index.php?page=view_rider&id=<?php echo $row['rider_id'] ?>'">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($riders->num_rows > 0): ?>
                        <div class="text-end mt-3">
                            <a href="../index.php?page=riders_list" class="text-success">View All Riders <i class="fa fa-arrow-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this after the Admin Login link -->
        <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="../index.php?page=riders_list">View Riders</a>
        </li>
    </div>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional: Include jQuery if required elsewhere -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
<?php $conn->close(); ?>