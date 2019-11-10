<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
            <?php if ($user["isAuthorized"]): ?>
                <span class="text-muted">Hello, <?php echo $user["fullname"]; ?></span>
            <?php endif; ?>
        </div>
        <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="<?php echo $hostWithScheme; ?>">SimpleVirtualCart</a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            <?php if ($user["isAuthorized"]): ?>
                <span class="text-muted">
                    Your balance: <span id="userBalance"><?php echo round($user["balance"], 2); ?></span>$
                </span>
                &nbsp;
                <a class="btn btn-sm btn-outline-secondary" href="<?php echo $url['profileCart']; ?>">Your Cart</a>
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