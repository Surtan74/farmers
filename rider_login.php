<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Rider Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #28a745, #218838);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container-fluid {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .control-label {
            color: #495057;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.8rem;
            width: 100%;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .btn-success {
            background: #28a745;
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .text-success {
            color: #28a745;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .text-success:hover {
            color: #218838;
            text-decoration: underline;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Rider Login</h3>
                <form action="" id="rider-login-frm">
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" name="username" id="username" required class="form-control" placeholder="Enter your username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" id="password" required class="form-control" placeholder="Enter your password">
                        <div class="mt-2">
                            <small><a href="javascript:void(0)" class="text-success" id="new_rider_account">Create Rider Account</a></small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#new_rider_account').click(function(e){
                e.preventDefault();
                location.href = 'rider_signup.php';
            });

            $('#rider-login-frm').submit(function(e){
                e.preventDefault();
                $('#rider-login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
                if($(this).find('.alert-danger').length > 0) {
                    $(this).find('.alert-danger').remove();
                }
                $.ajax({
                    url: 'admin/ajax.php?action=rider_login',
                    method: 'POST',
                    data: $(this).serialize(),
                    error: function(err){
                        console.log(err);
                        $('#rider-login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    },
                    success:function(resp){
                        if(resp == 1){
                            location.href = 'rider/index.php';
                        } else {
                            $('#rider-login-frm').prepend('<div class="alert alert-danger">Invalid username or password.</div>');
                            $('#rider-login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
