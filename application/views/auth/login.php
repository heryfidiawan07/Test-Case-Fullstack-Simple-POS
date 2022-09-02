<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= isset($title) ? $title : 'SYSTEM'; ?></title>
    <link href="https://majoo.id/favicon.png" rel='shortcut icon'>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap-social/bootstrap-social.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">

    <!-- Plygon -->
    <style type="text/css">
    body {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .card {
        box-shadow: 5px 5px 5px 5px #888888;
        border-radius: 5px;
    }
    #polygon {
        position: relative;
        height: 100%;
        width: 100%;
        background-color: rgb(30, 30, 30);
    }
    </style>
</head>
<body>
    <div id="polygon"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-3">
                <div class="row mt-0">
                    <div class="col-12 col-lg-2 col-xs-10 col-sm-8 col-lg-6 offset-lg-3 offset-xs-3 offset-sm-2 offset-lg-2">
                        <div class="login-brand" style="background: transparent; border: 0px !important;">
                            <img src="https://majoo.id/assets/img/main-logo.png" alt="majoo" width="300" class="">
                        </div>
                        <div class="card card-success" style="background-color: rgba(255,255,255,0.3);">
                            <div class="card-header"><h4>Login</h4></div>
                            <div class="card-body pb-0 pt-0">
                                <?= $this->session->flashdata('message'); ?>
                                <form id="form-login" method="POST" action="<?= base_url('login/store'); ?>" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">
                                                Password <i id="toggle-password" class="fas fa-eye-slash"></i>
                                            </label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
                                        Login
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center mt-4 mb-3">
                                    <div class="text-job text-muted"></div>
                                </div>
                                <div class="row sm-gutters">
                                </div>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; <?= date('Y')?>
                            <div class="bullet"></div>
                            <img src="https://majoo.id/assets/img/main-logo.png" style="width: 70px;">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="<?= base_url('assets/modules/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/external/js/popper.js') ?>"></script>
    <script src="<?= base_url('assets/external/js/tooltip.js') ?>"></script>
    <script src="<?= base_url('assets/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/stisla.js') ?>"></script>
    
    <!-- JS Libraies -->
    <script src="<?= base_url('assets/polygon/src/polygonizr.min.js') ?>"></script>
    <script>
    let $sitelading = $('#polygon')
    $sitelading.polygonizr({
        // nodeDotColor:"60, 45, 225",
        // nodeLineColor:"248, 120, 22",
        // nodeFillColor:"120, 95, 231",
    })

    // Update size.
    $(window).resize(function () {
        $sitelading.polygonizr("stop");
        $sitelading.polygonizr({
            canvasHeight: $(this).height(),
            canvasWidth: $(this).width()
        })

        $sitelading.polygonizr("refresh")
    });

    const tooglePassword = document.getElementById("toggle-password");
    let passwordInput = document.getElementById("password");
    tooglePassword.addEventListener('click', function(e) {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            tooglePassword.className = 'fas fa-eye';
        } else {
            passwordInput.type = "password";
            tooglePassword.className = 'fas fa-eye-slash';
        }
    })

    $('button').click(function() {
        $(this).attr('disabled', true)
        $('#form-login').submit()
    })
    </script>
    <!-- Page Specific JS File -->
    
    <!-- Template JS File -->
    <script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
    <script src="<?= base_url('assets/js/custom.js'); ?>"></script>
</body>
</html>