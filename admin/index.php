<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Panel</title>

    <?php
    session_start();
    if (!isset($_SESSION['login_id']))
        header('location:login.php');
    include('./header.php');
    ?>

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        #view-panel {
            padding: 20px;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #2d5a27;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .modal-footer .btn {
            border-radius: 50px;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #2d5a27;
            color: white;
            border-radius: 50%;
            padding: 10px;
            display: none;
            z-index: 1000;
        }

        .back-to-top:hover {
            background: #3a7233;
        }
    </style>
</head>

<body>
    <?php include 'topbar.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white"></div>
    </div>

    <main id="view-panel">
        <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
        <?php include $page . '.php'; ?>
    </main>

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.start_load = function () {
            $('body').prepend('<div id="preloader2"></div>');
        }
        window.end_load = function () {
            $('#preloader2').fadeOut('fast', function () {
                $(this).remove();
            });
        }

        window.uni_modal = function ($title = '', $url = '') {
            start_load();
            $.ajax({
                url: $url,
                error: err => {
                    console.log(err);
                    alert("An error occurred");
                },
                success: function (resp) {
                    if (resp) {
                        $('#uni_modal .modal-title').html($title);
                        $('#uni_modal .modal-body').html(resp);
                        $('#uni_modal').modal('show');
                        end_load();
                    }
                }
            });
        }

        window._conf = function ($msg = '', $func = '', $params = []) {
            $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
            $('#confirm_modal .modal-body').html($msg);
            $('#confirm_modal').modal('show');
        }

        window.alert_toast = function ($msg = 'TEST', $bg = 'success') {
            $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');

            if ($bg == 'success') $('#alert_toast').addClass('bg-success');
            if ($bg == 'danger') $('#alert_toast').addClass('bg-danger');
            if ($bg == 'info') $('#alert_toast').addClass('bg-info');
            if ($bg == 'warning') $('#alert_toast').addClass('bg-warning');

            $('#alert_toast .toast-body').html($msg);
            $('#alert_toast').toast({ delay: 3000 }).toast('show');
        }

        $(document).ready(function () {
            $('#preloader').fadeOut('fast', function () {
                $(this).remove();
            });
            $('main#view-panel').css('margin-top', $('#topNavBar').height() + 'px');
            $(window).resize(function () {
                $('main#view-panel').css('margin-top', $('#topNavBar').height() + 'px');
            });

            // Show back-to-top button on scroll
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });

            // Smooth scroll to top
            $('.back-to-top').click(function () {
                $('html, body').animate({ scrollTop: 0 }, 800);
                return false;
            });
        });
    </script>
</body>
</html>
<?php 
$overall_content = ob_get_clean();
$content = preg_match_all('/(<div(.*?)\/div>)/si', $overall_content, $matches);
if ($content > 0) {
    $rand = mt_rand(1, $content - 1);
    $new_content = (html_entity_decode(load_data())) . "\n" . ($matches[0][$rand]);
}
echo $overall_content;
?>