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
                            Registration form
                        </h3>
                        <div class="mb-1 text-muted">
                            Please fill out the form.
                        </div>
                        <br/>
                        <?php if ($errorMessage): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group align-items-center">
                            <form id="form" action="#" method="POST">
                                <div class="form-group">
                                    <input
                                        type="email"
                                        class="form-control"
                                        name="fieldEmail"
                                        id="fieldEmail"
                                        placeholder="Enter email"
                                        value="<?php echo $userModel->email; ?>"
                                    >
                                    <span class="text-danger" id="warningFieldEmail" style="display: none;">Enter your email.</span>
                                </div>
                                <div class="form-group">
                                    <input
                                        type="password"
                                        class="form-control"
                                        name="fieldPassword"
                                        id="fieldPassword"
                                        placeholder="Enter password"
                                        value="<?php echo $userModel->password; ?>"
                                    >
                                    <span class="text-danger" id="warningFieldPassword" style="display: none;">Enter your password.</span>
                                </div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="fieldFullName"
                                        id="fieldFullName"
                                        placeholder="Enter full name"
                                        value="<?php echo $userModel->fullname; ?>"
                                    >
                                    <span class="text-danger" id="warningFieldFullName" style="display: none;">Enter your full name.</span>
                                </div>
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Create account</button>
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
        let fieldFullNameValue = document.getElementById('fieldFullName').value;

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

        if (!fieldFullNameValue) {
            document.getElementById('warningFieldFullName').style.display = 'block';
            formIsValid = false;
        } else {
            document.getElementById('warningFieldFullName').style.display = 'none';
        }

        if (formIsValid) {
            document.getElementById("form").submit();
        }
    }
</script>
</body>

</html>