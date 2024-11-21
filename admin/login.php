<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Panel</title>
    
    <?php include('./header.php'); ?>
    <?php include('./db_connect.php'); ?>
    <?php 
    session_start();
    if(isset($_SESSION['login_id']))
        header("location:index.php?page=home");

    $query = $conn->query("SELECT * FROM system_settings LIMIT 1")->fetch_array();
    foreach ($query as $key => $value) {
        if(!is_numeric($key))
            $_SESSION['setting_'.$key] = $value;
    }
    ?>
    <style>
        body {
            width: 100%;
            height: 100vh;
            display: flex;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        main#main {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #login-container {
            width: 400px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo img {
            height: 80px;
            width: 80px;
        }

        h1 {
            font-family: 'Dancing Script', cursive;
            font-weight: bolder;
            font-size: 2.5em;
            color: #2d5a27;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .btn {
            width: 100%;
            padding: 0.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-dark {
            background: #2d5a27;
            border-color: #2d5a27;
            color: white;
        }

        .btn-dark:hover {
            background: #3a7233;
            border-color: #3a7233;
        }

        .alert {
            margin-top: 1rem;
        }

        .back-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <main id="main">
        <div id="login-container">
            
            <p style="text-align: center; font-family: 'Dancing Script', ; font-size: 2.8em; color: #2d5a27; text-shadow: 2px 2px 4px rgba(0,0,0,0.1); margin-bottom: 1.5rem; padding: 0 1rem;">Admin Login</p>
            <form id="login-form">
                <div class="form-group">
                    <label for="username" class="control-label">Username</label>
                    <input type="text" id="username" name="username" autofocus class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="back-link">
                    <a href="./../" class="text-dark">Back to Website</a>
                </div>
                <button type="submit" class="btn btn-dark">Login</button>
            </form>
        </div>
    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <script>
        $('#login-form').submit(function(e) {
            e.preventDefault();
            $('#login-form button[type="submit"]').attr('disabled', true).html('Logging in...');
            if ($(this).find('.alert-danger').length > 0)
                $(this).find('.alert-danger').remove();
            $.ajax({
                url: 'ajax.php?action=login',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err);
                    $('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
                },
                success: function(resp) {
                    if (resp == 1) {
                        location.href = 'index.php?page=home';
                    } else {
                        $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                        $('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });
    </script>
</body>
</html>