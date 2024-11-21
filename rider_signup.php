<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <title>Rider Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container-fluid {
            padding: 2rem;
        }

        form {
            max-width: 100%;
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
            margin-top: 1rem;
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

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        /* Animation for form elements */
        .form-group {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <form action="" id="rider-signup-frm">
            <div class="form-group">
                <label for="name" class="control-label">Full Name</label>
                <input type="text" name="name" id="name" required class="form-control" placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" name="username" id="username" required class="form-control" placeholder="Choose a username">
            </div>
            <div class="form-group">
                <label for="phone" class="control-label">Phone Number</label>
                <input type="text" name="phone" id="phone" required class="form-control" placeholder="Enter your phone number">
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" id="password" required class="form-control" placeholder="Create a password">
            </div>
            <input type="hidden" name="status" value="1">
            <button type="submit" class="btn btn-success btn-block">Create Account</button>
        </form>
    </div>

    <style>
        #uni_modal .modal-footer{
            display: none;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('#rider-signup-frm').submit(function(e){
                e.preventDefault();
                $('#rider-signup-frm button[type="submit"]').attr('disabled', true).html('Creating account...');
                if($(this).find('.alert-danger').length > 0) {
                    $(this).find('.alert-danger').remove();
                }
                $.ajax({
                    url:'admin/ajax.php?action=save_rider',
                    method:'POST',
                    data:$(this).serialize(),
                    error:function(err){
                        console.log(err);
                        $('#rider-signup-frm button[type="submit"]').removeAttr('disabled').html('Create Account');
                    },
                    success:function(resp){
                        if(resp == 1){
                            alert('Account created successfully!');
                            location.href = 'rider_login.php';
                        } else if(resp == 2){
                            $('#rider-signup-frm').prepend('<div class="alert alert-danger">Username already exists.</div>');
                            $('#rider-signup-frm button[type="submit"]').removeAttr('disabled').html('Create Account');
                        } else {
                            $('#rider-signup-frm').prepend('<div class="alert alert-danger">An error occurred.</div>');
                            $('#rider-signup-frm button[type="submit"]').removeAttr('disabled').html('Create Account');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>