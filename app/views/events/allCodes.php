<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('add_message') ?>
<div class="container w-75">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1><?php echo $data['title'] ?></h1>
        </div>

        <!-- create new -->
        <div class="col-md-6 me-0">
            <a href="<?php echo URLROOT ?>/events_dashboard/<?php echo $data['event_id'] ?>/discount_code/add" class="btn btn-secondary float-end">
                <i class="fa-regular fa-square-plus"></i>&nbsp&nbspCreate New
            </a>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <!-- table for discount code -->
        <tbody>
            <ul class="list-group mb-3">
                <?php foreach ($data['codes'] as $code) : ?>
                    <!-- each row: go to: /events_dashboard/1/discount_code/2 -->
                    <tr class="code-tr" onclick="window.location='<?php echo URLROOT ?>/events_dashboard/<?php echo $code->event_id ?>/discount_code/<?php echo $code->id ?>'">
                        <!-- code itself -->
                        <td><?php echo $code->code; ?></td>
                        <!-- code status -->
                        <td><?php
                            $current = date('Y-m-d H:i');
                            if ($current >= $code->start_date) {
                                if (!$code->end_date || $current <= $code->end_date) {
                                    echo 'active';
                                } else {
                                    echo 'inactive';
                                }
                            } else {
                                echo 'inactive';
                            }
                            ?></td>

                    </tr>

                <?php endforeach; ?>
            </ul>
        </tbody>
    </table>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>