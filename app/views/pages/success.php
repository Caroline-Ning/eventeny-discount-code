<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <div class="error-details">
                    <?php echo $data['message'] ?>
                </div>
                <div class="error-actions">
                    <a href="<?php echo URLROOT; ?>" class="btn btn-outline-primary btn-sm"><span class="glyphicon glyphicon-home"></span>Take Me Home </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>