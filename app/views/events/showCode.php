<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT ?>/events_dashboard/<?php echo $data["event_id"] ?>/discount_code" class="btn btn-light"><i class="fa-solid fa-angle-left"></i> Back</a>
<div class="container w-50">
    <?php flash('edit_message') ?>
    <br>
    <div class="d-flex justify-content-between">
        <div class="p-2">
            <h2>Code: <span class="text-primary"><?php echo $data['code']; ?></span></h2>
        </div>
        <div class="p-2">
            <h5 class="<?php if ($data['status'] == 'active') {
                            echo 'text-success';
                        } else {
                            echo 'text-secondary';
                        } ?>"><?php echo $data['status'] ?></h5>
        </div>
    </div>
    <ul class="list-group list-group-flush">
        <!-- type and value -->
        <li class="list-group-item d-flex justify-content-between align-items-start ps-0 ms-0">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Type and Discount Value</div>
                <?php if ($data['type'] == 'amount') {
                    echo 'Fixed Amount $' . $data['type_value'] . ' discount for this event';
                } elseif ($data['type'] == 'percentage') {
                    echo $data['type_value'] . '% discount for this event';
                } ?>
            </div>
        </li>

        <!-- other details -->
        <li class="list-group-item d-flex justify-content-between align-items-start ps-0 ms-0">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Details</div>
                <i class="fa-solid fa-angle-right"></i> <?php echo $data['customer_eligibility'] ?> <br>
                <i class="fa-solid fa-angle-right"></i> <?php echo $data['limit_times'] ?><br>
                <i class="fa-solid fa-angle-right"></i> <?php echo $data['limit_one'] ?><br>
                <i class="fa-solid fa-angle-right"></i> <?php echo $data['start_date'];
                                                        if ($data['end_date'] !== '') {
                                                            echo $data['end_date'];
                                                        } ?>
                <br>

            </div>
        </li>
    </ul>
    <!-- edit and delete btn -->
    <div class="row float-end">
        <div class="col">
            <div class="float-end">
                <a href="<?php echo URLROOT; ?>/events_dashboard/<?php echo $data['event_id'] ?>/discount_code/<?php echo $data['code_id']; ?>/edit" class="btn btn-outline-dark">Edit</a>
            </div>
        </div>
        <div class="col">
            <form action="<?php echo URLROOT; ?>/events_dashboard/<?php echo $data['event_id'] ?>/discount_code/<?php echo $data['code_id']; ?>/delete" method="post">
                <input type="submit" value="Delete" class="btn btn-outline-danger">
        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>