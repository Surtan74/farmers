<nav id="sidebar" class='mx-lt-5' style="background: #2d5a27;">
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home" style="color: #fff; padding: 15px 20px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease;"><span class='icon-field' style="margin-right: 10px;"><i class="fa fa-home"></i></span> Home</a>
				
				<a href="index.php?page=orders" class="nav-item nav-orders" style="color: #fff; padding: 15px 20px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease;"><span class='icon-field' style="margin-right: 10px;"><i class="fa fa-table"></i></span> Orders</a>
				
				<a href="index.php?page=menu" class="nav-item nav-menu" style="color: #fff; padding: 15px 20px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease;"><span class='icon-field' style="margin-right: 10px;"><i class="fa fa-leaf"></i></span> Menu</a>
				
				<a href="index.php?page=categories" class="nav-item nav-categories" style="color: #fff; padding: 15px 20px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease;"><span class='icon-field' style="margin-right: 10px;"><i class="fa fa-list"></i></span> Category List</a>
				
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users" style="color: #fff; padding: 15px 20px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease;"><span class='icon-field' style="margin-right: 10px;"><i class="fa fa-users"></i></span> Users</a>
				
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings" style="color: #fff; padding: 15px 20px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease;"><span class='icon-field' style="margin-right: 10px;"><i class="fa fa-cogs"></i></span> Site Settings</a>
				<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active').css({
		'background': '#3a7233',
		'border-left': '4px solid #fff'
	});
	
	$('.nav-item').hover(function() {
		$(this).css('background', '#3a7233');
	}, function() {
		if(!$(this).hasClass('active')) {
			$(this).css('background', 'transparent');
		}
	});
</script>