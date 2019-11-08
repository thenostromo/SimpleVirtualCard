<!DOCTYPE html>
<html>

<head>
    <?php include_once 'embed/html_head.php' ?>
</head>

<body>
<div class="container">
    <?php include_once 'embed/header.php' ?>
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card flex-md-row mb-4 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0">
                            Authorization form
                        </h3>
                        <div class="mb-1 text-muted">
                            Please enter your email and password.
                        </div>
                        <br/>
                        <div class="form-group align-items-center">
                            <form id="form" action="#" method="POST">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="warningFieldEmail" id="fieldEmail" placeholder="Enter email">
                                    <span class="text-danger" id="warningFieldEmail" style="display: none;">Enter your email.</span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="fieldPassword" id="fieldPassword" placeholder="Enter password">
                                    <span class="text-danger" id="warningFieldPassword" style="display: none;">Enter your password.</span>
                                </div>
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include_once 'embed/html_scripts.php' ?>
<script>
    function submitForm()
    {
        let formIsValid = true;
        let fieldEmailValue = document.getElementById('fieldEmail').value;
        let fieldPasswordValue = document.getElementById('fieldPassword').value;

        if (!fieldEmailValue) {
            document.getElementById('warningFieldEmail').style.display = 'block';
            formIsValid = false;
        } else {
            document.getElementById('warningFieldEmail').style.display = 'none';
        }

        if (!fieldPasswordValue) {
            document.getElementById('warningFieldPassword').style.display = 'block';
            formIsValid = false;
        } else {
            document.getElementById('warningFieldPassword').style.display = 'none';
        }

        if (formIsValid) {
            document.getElementById("form").submit();
        }
    }
</script>
</body>

</html>