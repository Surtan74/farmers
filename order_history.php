<?php
session_start();
include 'admin/db_connect.php';

$user_id = $_SESSION['login_user_id'];

// Validate user_id
if (!isset($user_id) || !is_numeric($user_id)) {
    echo "<div class='alert alert-danger'>Invalid user session.</div>";
    exit;
}

// Prepare and execute the query with proper JOIN syntax
$query = "SELECT o.*, COUNT(ol.id) as item_count, 
          GROUP_CONCAT(CONCAT(ol.qty, 'x ', p.name) SEPARATOR ', ') as items
          FROM orders o 
          LEFT JOIN order_list ol ON o.id = ol.order_id 
          LEFT JOIN product_list p ON ol.product_id = p.id
          WHERE o.email = (SELECT email FROM user_info WHERE user_id = ?) 
          GROUP BY o.id 
          ORDER BY o.id DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "<div class='alert alert-danger'>Query preparation failed: " . $conn->error . "</div>";
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

if (!$orders) {
    echo "<div class='alert alert-danger'>Query execution failed: " . $conn->error . "</div>";
    exit;
}
?>

<div class="container">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Order History</h5>
        </div>
        <div class="card-body">
            <?php if($orders->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']) ?></td>
                            <td><?php echo isset($row['date_created']) ? date('M d, Y', strtotime($row['date_created'])) : 'N/A' ?></td>
                            <td>
                                <small><?php echo htmlspecialchars($row['items']) ?></small>
                                <br>
                                <small class="text-muted">(<?php echo $row['item_count'] ?> items)</small>
                            </td>
                            <td>
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge bg-success">Confirmed</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                            </td>
                            
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <h6 class="text-muted">No orders found</h6>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 10px 10px 0 0;
}

.table th {
    background-color: #f8f9fa;
}

.badge {
    padding: 0.5em 1em;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
}

.btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
    color: white;
}
</style>

<script>
$(document).ready(function(){
    // Handle view order details
    $('.view_order').click(function(){
        var orderId = $(this).data('id');
        uni_modal('Order Details', 'view_order.php?id=' + orderId);
    });
});
</script>
