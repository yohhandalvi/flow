<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('admin/layout/head'); ?>
</head>
<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">
                            <p class=" text-white h2">MAGIC IS IN THE DETAILS</p>
                            <p class="white mb-0">
                                Please use your credentials to reset your password.
                                <br>If you are not a member, please
                                <a href="<?php echo site_url('register'); ?>" class="white">register</a>.
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="<?php echo site_url('admin'); ?>">
                                <span class="logo-single"></span>
                            </a>
                            <?php $this->load->view('admin/layout/alert'); ?>
                            <h6 class="mb-4">Forgot Password</h6>
                            <form method="post">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="domain" value="<?php $this->input->post('domain'); ?>" />
                                    <?php echo form_error('domain'); ?>
                                    <span>Domain</span>
                                </label>
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="email" value="<?php $this->input->post('email'); ?>" />
                                    <?php echo form_error('email'); ?>
                                    <span>E-mail</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?php echo site_url('admin'); ?>">Login?</a>
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">RESET PASSWORD</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('admin/layout/foot'); ?>
</body>
</html>