<nav class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="d-flex align-items-center col-md-6 mb-md-0 ">
        <a href="<?php echo URLROOT ?>" class="text-dark text-decoration-none">
            <h3 style="color:#00a4bd"><?php echo SITENAME ?></h3>
        </a>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <a href="<?php echo URLROOT ?>/events_dashboard" class="nav-link link-secondary">Events Dashboard</a>
        <a href="<?php echo URLROOT ?>/cart/0" class="nav-link link-secondary">Cart</a>
    </ul>

    <div class="col text-end">
        <?php if (isset($_SESSION["user_id"])) : ?>
            <span class="text-secondary me-5 text-decoration-none">Welcome <?php echo $_SESSION["user_name"] ?></span>
            <a href="<?php echo URLROOT ?>/users/logout"><button type="button" class="btn btn-outline-primary me-2">Logout</button></a>
        <?php else : ?>
            <a href="<?php echo URLROOT ?>/users/login"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
            <a href="<?php echo URLROOT ?>/users/register"><button type="button" class="btn btn-outline-primary"> Sign-up</button></a>
        <?php endif; ?>
    </div>
</nav>