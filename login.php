<?php session_start() ?>
<div class="container-fluid bg-cart d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow-lg w-100" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Login to Your Account</h3>
            <form action="" id="login-frm">
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" name="email" id="email" required class="form-control" placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" id="password" required class="form-control" placeholder="Enter your password">
                    <small><a href="javascript:void(0)" class="text-success" id="new_account">Create New Account</a></small>
                </div>
                <button type="submit" class="btn btn-success btn-block">Login</button>
                <div class="mt-3 text-center">
                    <a href="forgot_password.php" class="text-success">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Hide modal footer if applicable */
    #uni_modal .modal-footer {
        display: none;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
    }

    .card-title {
        font-family: 'Dancing Script', ;
        font-size: 2em;
        color: #2d5a27;
    }

    /* Button Styling */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Form Labels */
    .form-group label {
        font-weight: bold;
        color: #2d5a27;
    }

    /* Input Fields */
    .form-control {
        border-radius: 10px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

    /* Link Styling */
    #new_account {
        text-decoration: none;
        font-weight: bold;
    }

    #new_account:hover {
        text-decoration: underline;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .card {
            margin: 20px;
        }

        .card-title {
            font-size: 1.5em;
        }
    }
</style>

<!-- Scripts -->
<script>
    $(document).ready(function(){
        // Open Signup Modal
        $('#new_account').click(function(){
            uni_modal("Create an Account",'signup.php?redirect=index.php?page=checkout')
        });

        // Handle Login Form Submission
        $('#login-frm').submit(function(e){
            e.preventDefault();
            $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
            
            // Remove existing error messages
            if($(this).find('.alert-danger').length > 0 )
                $(this).find('.alert-danger').remove();
            
            $.ajax({
                url: 'admin/ajax.php?action=login2',
                method: 'POST',
                data: $(this).serialize(),
                error: function(err){
                    console.log(err);
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                },
                success: function(resp){
                    if(resp == 1){
                        location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
                    } else{
                        $('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>');
                        $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });
    });
</script>