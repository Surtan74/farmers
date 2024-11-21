 <script>
 	$('.datepicker').datepicker({
 		format:"yyyy-mm-dd"
 	})
 	 window.uni_modal = function($title = '', $url = '', $size = '') {
    $.ajax({
        url: $url,
        error: err => {
            console.log(err);
            alert("An error occurred");
        },
        success: function(resp) {
            if(resp) {
                $('#uni_modal .modal-title').html($title);
                $('#uni_modal .modal-body').html(resp);
                if($size == 'md') {
                    $('#uni_modal .modal-dialog').addClass('modal-md').removeClass('modal-lg modal-sm');
                } else if($size == 'lg') {
                    $('#uni_modal .modal-dialog').addClass('modal-lg').removeClass('modal-md modal-sm');
                } else if($size == 'sm') {
                    $('#uni_modal .modal-dialog').addClass('modal-sm').removeClass('modal-md modal-lg');
                } else {
                    $('#uni_modal .modal-dialog').removeClass('modal-md modal-lg modal-sm');
                }
                
                $('#uni_modal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
        }
    });
}
  window.uni_modal_right = function($title = '' , $url=''){
    $.ajax({
        url: $url,
        error: err => {
            console.log();
            alert("An error occurred");
        },
        success: function(resp){
            if(resp){
                $('#uni_modal_right .modal-title').html($title);
                $('#uni_modal_right .modal-body').html(resp);
                $('#uni_modal_right').modal('show');
            }
        }
    });
}
window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }
  window.load_cart = function(){
    $.ajax({
      url:'admin/ajax.php?action=get_cart_count',
      success:function(resp){
        if(resp > -1){
          resp = resp > 0 ? resp : 0;
          $('.item_count').html(resp)
        }
      }
    })
  }
  $('#login_now').click(function(){
    uni_modal("LOGIN",'login.php')
  })
  $(document).ready(function(){
    load_cart()
    // Handle profile view
    $('#view_profile').click(function(){
        uni_modal("My Profile", "user_profile.php", "md");
    });

    // Handle profile update
    $(document).on('submit', '#update_profile', function(e){
        e.preventDefault();
        $.ajax({
            url: 'admin/ajax.php?action=update_profile',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                try {
                    resp = JSON.parse(resp);
                    if(resp.status == 1){
                        alert_toast("Profile updated successfully", "success");
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast(resp.msg || "Error updating profile", "danger");
                    }
                } catch(e) {
                    console.log(e);
                    alert_toast("Error updating profile", "danger");
                }
            },
            error: function(err){
                console.log(err);
                alert_toast("An error occurred", "danger");
            }
        });
    });

    // Handle order detail view
    $(document).on('click', '.view_order', function(){
        uni_modal("Order Details", "view_order.php?id=" + $(this).attr('data-id'));
    });

    // Handle order history view
    $('#view_orders').click(function(){
        $.ajax({
            url: 'order_history.php',
            success: function(resp){
                $('#uni_modal .modal-title').html('Order History');
                $('#uni_modal .modal-body').html(resp);
                $('#uni_modal').modal('show');
            },
            error: function(err){
                console.log(err);
                alert_toast("An error occurred", "danger");
            }
        });
    });
  })
 </script>
 <!-- Bootstrap core JS-->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
  <!-- Third party plugin JS-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
  <style>
.modal-md {
    max-width: 600px;
}
.modal-lg {
    max-width: 900px;
}
.modal {
    z-index: 9999;
}
.modal.fade .modal-dialog {
    transition: transform 0.2s ease-out;
}

.modal.show .modal-dialog {
    transform: none;
}
</style>