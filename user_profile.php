<?php
session_start();
include 'admin/db_connect.php';

if(!isset($_SESSION['login_user_id'])){
    echo "<div class='alert alert-danger'>Session expired. Please login again.</div>";
    exit;
}

$user_id = $_SESSION['login_user_id'];
$user = $conn->query("SELECT * FROM user_info WHERE user_id = $user_id");

if(!$user || $user->num_rows == 0){
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit;
}

$user = $user->fetch_array();
?>

<div class="container">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">My Profile</h5>
        </div>
        <div class="card-body">
            <form id="update_profile">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?php echo $user['email'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control" value="<?php echo $user['mobile'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3" required><?php echo $user['address'] ?></textarea>
                </div>
                
            </form>
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

.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    border-radius: 5px;
}

.btn-success {
    padding: 8px 25px;
}
</style>
