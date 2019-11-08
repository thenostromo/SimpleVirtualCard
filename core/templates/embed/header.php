<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
            <?php if ($isAuthorized): ?>
                <a class="text-muted" href="#">Hello, Alexander</a>
            <?php endif; ?>
        </div>
        <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="<?php echo $hostWithScheme; ?>">SimpleVirtualCart</a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            <?php if ($isAuthorized): ?>
                <a class="text-muted" href="#">
                    Your Cart
                </a>
                &nbsp;
                <a class="btn btn-sm btn-outline-secondary" href="<?php echo $url['logout']; ?>">Logout</a>
            <?php else: ?>
                <a class="btn btn-sm btn-outline-secondary" href="<?php echo $url['signIn']; ?>">Sign in</a>
                &nbsp;
                <a class="btn btn-sm btn-outline-secondary" href="<?php echo $url['registration']; ?>">Registration</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<br/>