 <?php
    function renderOrderTable($orders, $type)
    {
    ?>
     <div class="card">
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>Order ID</th>
                             <th>Customer</th>
                             <th>Address</th>
                             <th>Contact</th>
                             <th>Status</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $orders->fetch_assoc()): ?>
                             <tr>
                                 <td>#<?php echo $row['id'] ?></td>
                                 <td><?php echo $row['name'] ?></td>
                                 <td><?php echo $row['address'] ?></td>
                                 <td><?php echo $row['mobile'] ?></td>
                                 <td>
                                     <?php
                                        $badge_class = '';
                                        $status_text = '';

                                        switch ($row['delivery_status']) {
                                            case 'pending':
                                                $badge_class = 'badge-pending';
                                                $status_text = 'Pending';
                                                break;
                                            case 'assigned':
                                                $badge_class = 'badge-assigned';
                                                $status_text = 'Assigned';
                                                break;
                                            case 'completed':
                                                $badge_class = 'badge-completed';
                                                $status_text = 'Completed';
                                                break;
                                        }
                                        ?>
                                     <span class="badge <?php echo $badge_class ?>">
                                         <?php echo $status_text ?>
                                     </span>
                                 </td>
                                 <td>
                                     <?php if ($type === 'available'): ?>
                                         <button class="btn btn-action btn-accept accept_order" type="button" data-id="<?php echo $row['id'] ?>">
                                             <i class="fas fa-check"></i> Accept
                                         </button>
                                     <?php elseif ($type === 'active'): ?>
                                         <button class="btn btn-action btn-accept complete_delivery" type="button" data-id="<?php echo $row['id'] ?>">
                                             <i class="fas fa-check-circle"></i> Complete
                                         </button>
                                     <?php else: ?>
                                         <button class="btn btn-action btn-view view_order" type="button" data-id="<?php echo $row['id'] ?>">
                                             <i class="fas fa-eye"></i> View
                                         </button>
                                     <?php endif; ?>
                                 </td>
                             </tr>
                         <?php endwhile; ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 <?php
    }
    ?>