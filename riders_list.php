<?php
include('admin/db_connect.php');
?>

<div class="container py-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Our Delivery Riders</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Current Deliveries</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $riders = $conn->query("SELECT r.*, 
                            (SELECT COUNT(*) FROM orders WHERE rider_id = r.rider_id AND delivery_status = 'assigned') as active_deliveries 
                            FROM riders r WHERE status = 1");
                        while($row = $riders->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
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
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(45deg, #2d5a27, #3a7233) !important;
            border-radius: 8px 8px 0 0 !important;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .badge {
            padding: 0.5em 1em;
            border-radius: 50px;
        }
        
        .bg-success {
            background-color: #2d5a27 !important;
        }
        
        .bg-info {
            background-color: #3a7233 !important;
        }
    </style>
</div> 