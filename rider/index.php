<?php
include '../admin/db_connect.php';
include 'components/order_table.php';
session_start();

if (!isset($_SESSION['rider_username']))
    header('location:../rider_login.php');

$rider_id = $_SESSION['rider_rider_id'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Rider Dashboard</title>
    <?php include('../admin/header.php') ?>
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .container-fluid {
            padding: 2rem;
        }

        .dashboard-header {
            background: #28a745;
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #495057;
            font-size: 0.9rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-assigned {
            background-color: #17a2b8;
            color: #fff;
        }

        .btn-complete {
            background-color: #28a745;
            color: white;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-complete:hover {
            background-color: #218838;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .table-responsive {
                border: 0;
            }
            
            .container-fluid {
                padding: 1rem;
            }
            
            .dashboard-header {
                padding: 1rem;
            }
            
            .dashboard-header h2 {
                font-size: 1.5rem;
            }
        }

        /* Loading Animation */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Add new styles for tabs */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #495057;
            font-weight: 500;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #28a745;
            border-bottom: 2px solid #28a745;
        }

        .nav-tabs .nav-link:hover {
            color: #28a745;
        }

        /* Status badge colors */
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-assigned {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-completed {
            background-color: #28a745;
            color: #fff;
        }

        /* Action buttons */
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
            margin: 0 0.2rem;
        }

        .btn-accept {
            background-color: #28a745;
            color: white;
        }

        .btn-accept:hover {
            background-color: #218838;
        }

        .btn-view {
            background-color: #17a2b8;
            color: white;
        }

        .btn-view:hover {
            background-color: #138496;
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading">
        <div class="loading-spinner"></div>
    </div>

    <div class="container-fluid">
        <div class="dashboard-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Orders Dashboard</h2>
                <div>
                    <button class="btn btn-light mr-2" onclick="location.reload()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-light" onclick="location.href='../admin/ajax.php?action=rider_logout'">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="available-tab" data-toggle="tab" href="#available" role="tab">
                    Available Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="my-orders-tab" data-toggle="tab" href="#my-orders" role="tab">
                    My Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab">
                    Completed Orders
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="orderTabsContent">
            <!-- Available Orders -->
            <div class="tab-pane fade show active" id="available" role="tabpanel">
                <?php
                $available_orders = $conn->query("SELECT * FROM orders WHERE rider_id IS NULL AND delivery_status = 'pending'");
                renderOrderTable($available_orders, 'available');
                ?>
            </div>

            <!-- My Orders -->
            <div class="tab-pane fade" id="my-orders" role="tabpanel">
                <?php
                $active_orders = $conn->query("SELECT * FROM orders WHERE rider_id = $rider_id AND delivery_status = 'assigned'");
                renderOrderTable($active_orders, 'active');
                ?>
            </div>

            <!-- Completed Orders -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <?php
                $completed_orders = $conn->query("SELECT * FROM orders WHERE rider_id = $rider_id AND delivery_status = 'completed'");
                renderOrderTable($completed_orders, 'completed');
                ?>
            </div>
        </div>
    </div>

    <!-- Add this new script for real-time updates -->
    <script>
        function checkForUpdates() {
            $.ajax({
                url: '../admin/ajax.php?action=check_order_updates',
                method: 'POST',
                data: { last_update: window.lastUpdate || 0 },
                success: function(resp) {
                    if(resp.hasUpdates) {
                        location.reload();
                    }
                    window.lastUpdate = resp.timestamp;
                }
            });
        }

        // Check for updates every 30 seconds
        setInterval(checkForUpdates, 30000);
    </script>

    <script>
        // Accept Order
        $('.accept_order').click(function() {
            var order_id = $(this).attr('data-id');
            if (confirm("Accept this order for delivery?")) {
                $('.loading').css('display', 'flex');
                $.ajax({
                    url: '../admin/ajax.php?action=accept_order',
                    method: 'POST',
                    data: {
                        order_id: order_id,
                        rider_id: '<?php echo $_SESSION['rider_rider_id'] ?>'
                    },
                    success: function(resp) {
                        if (resp == 1) {
                            alert_toast("Order accepted successfully");
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    complete: function() {
                        $('.loading').css('display', 'none');
                    }
                });
            }
        });

        // Complete Delivery
        $('.complete_delivery').click(function() {
            var order_id = $(this).attr('data-id');
            if (confirm("Mark this delivery as completed?")) {
                $('.loading').css('display', 'flex');
                $.ajax({
                    url: '../admin/ajax.php?action=complete_delivery',
                    method: 'POST',
                    data: {
                        id: order_id
                    },
                    success: function(resp) {
                        if (resp == 1) {
                            alert_toast("Delivery marked as completed");
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    complete: function() {
                        $('.loading').css('display', 'none');
                    }
                });
            }
        });

        // View Order Details
        $('.view_order').click(function() {
            var order_id = $(this).attr('data-id');
            uni_modal("Order Details", "../admin/view_order.php?id=" + order_id);
        });
    </script>
</body>

</html>