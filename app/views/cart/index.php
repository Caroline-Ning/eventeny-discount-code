<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-4" style="width: 90%">
    <h1><?php echo $data['title'] ?></h1>
    <div class="row">
        <div class="col-sm-7">
            <div class="card" style="width: 95%;margin-top:30px">
                <div class="card-body">
                    <h5 class="card-title">Sample Event</h5>
                    <p class="card-text">
                        This page is built for the demonstration of applying a discount code. The user is going to check out the sample event. Since we don't have a table for events, all event creators are working on the same sample event. The user can use any discount code (within its limitations) in the database.</p>
                    <p class="card-text text-primary">
                        The discount code is used when you place the order</p>
                </div>
            </div>
        </div>
        <div class="col-sm-5 pt-3 pb-3" style="background-color:#eee;margin-top:30px">
            <div style="width: 80%" class="mx-auto">

                <!-- input to apply code -->
                <form action="<?php echo URLROOT ?>/cart/<?php echo $data["event_id"] ?>" method="post" class="mb-4">
                    <div class="form-group mb-3 mt-3 ">
                        <label for="coupon" class="mb-2">Coupon</label>
                        <input type="text" name="apply" class="form-control form-control-sm <?php echo (!empty($data['apply_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['apply']; ?>">

                        <!-- err msg/success msg for empty code -->
                        <span class="invalid-feedback"><?php echo $data['apply_err']; ?></span>
                        <span class="text-success" style="font-size: 14px"><?php echo $data['apply_success']; ?></span>

                    </div>
                    <input type="submit" value="Apply" class="btn btn-outline-primary">
                </form>
                <hr class="border-1 border-top border-secondary mx-auto" style="width: 100%">

                <!-- subtotal, tax -->
                <div class="d-flex justify-content-between mt-4">
                    <p>Subtotal</p>
                    <p>$<?php echo $data['subtotal'] ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Tax</p>
                    <div class="pt-2">
                        <p class="text-secondary" style="font-size: 8px">To be calculated</p>
                    </div>
                </div>
                <hr class="border-1 border-top border-secondary mx-auto" style="width: 100%">

                <!-- total -->
                <div class="d-flex justify-content-between mt-4">
                    <p>Total</p>
                    <div>
                        <p class="text-secondary" style="font-size: 12px">USD<span style="color:black;font-size: 16px"> $<?php echo $data['total'] ?></span></p>
                    </div>
                </div>

                <!-- place order -->
                <form action="<?php echo URLROOT ?>/cart/<?php echo $data["event_id"] ?>/checkout/<?php echo $data["valid_code_id"] ?>" method="post">
                    <div class="d-flex justify-content-center mt-4"><input class='btn btn-outline-secondary' type="submit" value="Place Your Order" style="width: 100%"></div>
                </form>
            </div>
        </div>


    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>