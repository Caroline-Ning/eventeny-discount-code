<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container w-75 mt-4">
    <h1><?php echo $data['title'] ?></h1>
    <div class="card" style="width: 50%;margin-top:40px">
        <div class="card-body mt-2 mb-2">
            <h5 class="card-title">Sample Event</h5>
            <p class="card-text">This is a sample event which only contains a link to mangage the discount codes of this sample event. Since we don't have a table for events, all event creators are working on the same sample event. You only have access to the discount codes created by yourself.</p>
            <p class="card-text">Attendance Fee $30</p>
            <a href="<?php echo URLROOT ?>/events_dashboard/0/discount_code" class="card-link text-decoration-none">Discount Codes</a>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>