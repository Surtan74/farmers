<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include 'db_connect.php';
                    $riders = $conn->query("SELECT * FROM riders");
                    while($row = $riders->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['rider_id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['status'] == 1 ? "Active" : "Inactive" ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary edit_rider" data-id="<?php echo $row['rider_id'] ?>">Edit</button>
                            <button class="btn btn-sm btn-danger delete_rider" data-id="<?php echo $row['rider_id'] ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#new_rider').click(function(){
        uni_modal("New Rider","manage_rider.php");
    });
    
    $('.edit_rider').click(function(){
        uni_modal("Edit Rider","manage_rider.php?id="+$(this).attr('data-id'));
    });

    $('.delete_rider').click(function(){
        _conf("Are you sure you want to delete this rider?","delete_rider",[$(this).attr('data-id')]);
    });

    function delete_rider($id){
        start_load();
        $.ajax({
            url:'ajax.php?action=delete_rider',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Rider successfully deleted",'success');
                    setTimeout(function(){
                        location.reload();
                    },1500);
                }
            }
        });
    }
</script>
