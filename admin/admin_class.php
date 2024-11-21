<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM `users` where username = '".$username."' ");
		if($qry->num_rows > 0){
			$result = $qry->fetch_array();
			$is_verified = password_verify($password, $result['password']);
			if($is_verified){
			foreach ($result as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
			}
		}
			return 3;
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM user_info where email = '".$email."' ");
		if($qry->num_rows > 0){
			$result = $qry->fetch_array();
			$is_verified = password_verify($password, $result['password']);
			if($is_verified){
				foreach ($result as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
				$this->db->query("UPDATE cart set user_id = '".$_SESSION['login_user_id']."' where client_ip ='$ip' ");
					return 1;
			}
		}
			return 3;
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$data = " `name` = '$name' ";
		$data .= ", `username` = '$username' ";
		$data .= ", `password` = '$password' ";
		$data .= ", `type` = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$data = " first_name = '$first_name' ";
		$data .= ", last_name = '$last_name' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", password = '$password' ";
		$chk = $this->db->query("SELECT * FROM user_info where email = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO user_info set ".$data);
		if($save){
			$login = $this->login2();
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO category_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE category_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM category_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_menu(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", description = '$description' ";
		if(isset($status) && $status  == 'on')
		$data .= ", status = 1 ";
		else
		$data .= ", status = 0 ";

		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", img_path = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO product_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE product_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_menu(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM product_list where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_cart(){
		extract($_GET);
		$delete = $this->db->query("DELETE FROM cart where id = ".$id);
		if($delete)
			header('location:'.$_SERVER['HTTP_REFERER']);
	}
	function add_to_cart(){
		extract($_POST);
		$data = " product_id = $pid ";	
		$qty = isset($qty) ? $qty : 1 ;
		$data .= ", qty = $qty ";	
		if(isset($_SESSION['login_user_id'])){
			$data .= ", user_id = '".$_SESSION['login_user_id']."' ";	
		}else{
			$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
			$data .= ", client_ip = '".$ip."' ";	

		}
		$save = $this->db->query("INSERT INTO cart set ".$data);
		if($save)
			return 1;
	}
	function get_cart_count(){
		extract($_POST);
		if(isset($_SESSION['login_user_id'])){
			$where =" where user_id = '".$_SESSION['login_user_id']."'  ";
		}
		else{
			$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
			$where =" where client_ip = '$ip'  ";
		}
		$get = $this->db->query("SELECT sum(qty) as cart FROM cart ".$where);
		if($get->num_rows > 0){
			return $get->fetch_array()['cart'];
		}else{
			return '0';
		}
	}

	function update_cart_qty(){
		extract($_POST);
		$data = " qty = $qty ";
		$save = $this->db->query("UPDATE cart set ".$data." where id = ".$id);
		if($save)
		return 1;	
	}

	function save_order(){
		extract($_POST);
		$data = " name = '".$first_name." ".$last_name."' ";
		$data .= ", address = '$address' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", email = '$email' ";
		$save = $this->db->query("INSERT INTO orders set ".$data);
		if($save){
			$id = $this->db->insert_id;
			$qry = $this->db->query("SELECT * FROM cart where user_id =".$_SESSION['login_user_id']);
			while($row= $qry->fetch_assoc()){

					$data = " order_id = '$id' ";
					$data .= ", product_id = '".$row['product_id']."' ";
					$data .= ", qty = '".$row['qty']."' ";
					$save2=$this->db->query("INSERT INTO order_list set ".$data);
					if($save2){
						$this->db->query("DELETE FROM cart where id= ".$row['id']);
					}
			}
			return 1;
		}
	}
function confirm_order(){
	extract($_POST);
		$save = $this->db->query("UPDATE orders set status = 1 where id= ".$id);
		if($save)
			return 1;
}

function rider_login(){
    extract($_POST);
    $qry = $this->db->query("SELECT * FROM riders where username = '".$username."' ");
    if($qry->num_rows > 0){
        $result = $qry->fetch_array();
        if(password_verify($password, $result['password'])){
            foreach ($result as $key => $value) {
                if($key != 'password' && !is_numeric($key))
                    $_SESSION['rider_'.$key] = $value;
            }
            return 1;
        }
    }
    return 3;
}

function accept_order(){
    extract($_POST);
    $update = $this->db->query("UPDATE orders SET 
        rider_id = '$rider_id', 
        delivery_status = 'assigned',
        status = 1,
        date_updated = NOW()
        WHERE id = '$order_id'");
    
    if($update) {
        // Log the status change
        $this->db->query("INSERT INTO order_updates (order_id, status, rider_id, update_time) 
            VALUES ('$order_id', 'assigned', '$rider_id', NOW())");
        return 1;
    }
    return 0;
}

function complete_delivery(){
    extract($_POST);
    $update = $this->db->query("UPDATE orders SET 
        delivery_status = 'completed',
        date_completed = NOW()
        WHERE id = '$id'");
    
    if($update) {
        // Log the status change
        $this->db->query("INSERT INTO order_updates (order_id, status, rider_id, update_time) 
            VALUES ('$id', 'completed', '".$_SESSION['rider_rider_id']."', NOW())");
        return 1;
    }
    return 0;
}

function save_rider(){
    try {
        extract($_POST);
        
        // Validate required fields
        if(empty($name) || empty($username) || empty($phone) || !isset($status)) {
            return 0;
        }
        
        // Sanitize inputs
        $name = $this->db->real_escape_string($name);
        $username = $this->db->real_escape_string($username);
        $phone = $this->db->real_escape_string($phone);
        $status = (int)$status;
        
        // Build data array
        $data = array(
            "name" => $name,
            "username" => $username,
            "phone" => $phone,
            "status" => $status
        );
        
        // Handle password
        if(!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Check for existing username
        if(empty($id)) {
            // New rider
            $check = $this->db->query("SELECT rider_id FROM riders WHERE username = '$username'");
            if($check && $check->num_rows > 0) {
                return 2; // Username exists
            }
            
            // Build INSERT query
            $fields = implode("`, `", array_keys($data));
            $values = implode("', '", $data);
            $sql = "INSERT INTO riders (`$fields`) VALUES ('$values')";
        } else {
            // Update existing rider
            $id = (int)$id;
            $updates = array();
            foreach($data as $key => $value) {
                $updates[] = "`$key` = '$value'";
            }
            $sql = "UPDATE riders SET " . implode(", ", $updates) . " WHERE rider_id = $id";
        }
        
        $save = $this->db->query($sql);
        
        if($save) {
            return 1; // Success
        }
        return 0; // Failed
        
    } catch (Exception $e) {
        error_log("Error in save_rider: " . $e->getMessage());
        return 0;
    }
}

function check_order_updates(){
    extract($_POST);
    $last_update = isset($last_update) ? $last_update : 0;
    
    $query = $this->db->query("SELECT MAX(update_time) as latest FROM order_updates 
        WHERE UNIX_TIMESTAMP(update_time) > $last_update");
    $result = $query->fetch_assoc();
    
    $response = array(
        'hasUpdates' => $query->num_rows > 0 && $result['latest'] != null,
        'timestamp' => time()
    );
    
    echo json_encode($response);
    exit;
}

function update_profile(){
    extract($_POST);
    
    if(!isset($_SESSION['login_user_id'])){
        echo json_encode(['status' => 0, 'msg' => 'Session expired']);
        return;
    }
    
    // Validate and sanitize inputs
    $first_name = $this->db->real_escape_string($first_name);
    $last_name = $this->db->real_escape_string($last_name);
    $mobile = $this->db->real_escape_string($mobile);
    $address = $this->db->real_escape_string($address);
    
    // Build update query
    $data = " first_name = '$first_name' ";
    $data .= ", last_name = '$last_name' ";
    $data .= ", mobile = '$mobile' ";
    $data .= ", address = '$address' ";
    
    // Update user_info table
    $save = $this->db->query("UPDATE user_info set ".$data." where user_id = ".$_SESSION['login_user_id']);
    
    if($save){
        // Update session variables
        $_SESSION['login_first_name'] = $first_name;
        $_SESSION['login_last_name'] = $last_name;
        echo json_encode(['status' => 1, 'msg' => 'Profile updated successfully']);
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Error: ' . $this->db->error]);
    }
}

function get_user_orders(){
    $user_id = $_SESSION['login_user_id'];
    
    $qry = $this->db->query("SELECT o.*, 
        GROUP_CONCAT(CONCAT(ol.qty, ' x ', p.name) SEPARATOR '\n') as order_items,
        SUM(ol.qty * p.price) as total_amount
        FROM orders o 
        LEFT JOIN order_list ol ON o.id = ol.order_id 
        LEFT JOIN product_list p ON ol.product_id = p.id 
        WHERE o.user_id = $user_id 
        GROUP BY o.id 
        ORDER BY o.date_created DESC");
    
    $orders = array();
    while($row = $qry->fetch_assoc()){
        $row['status_label'] = $row['status'] == 1 ? 'Confirmed' : 'Pending';
        $row['delivery_status_label'] = ucfirst($row['delivery_status'] ?? 'pending');
        $row['date_created'] = date("M d, Y h:i A", strtotime($row['date_created']));
        $orders[] = $row;
    }
    
    return json_encode($orders);
}

}