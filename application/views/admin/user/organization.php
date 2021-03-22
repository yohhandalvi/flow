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
                        </div>
                        <div class="form-side">
                            <a href="<?php echo site_url('admin'); ?>">
                                <span class="logo-single"></span>
                            </a>
                            <?php $this->load->view('admin/layout/alert'); ?>
                            <h6 class="mb-4">Enter your organization details</h6>
                            <form method="post">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="organization_name" value="<?php $this->input->post('organization_name'); ?>" />
                                    <?php echo form_error('organization_name'); ?>
                                    <span>Name</span>
                                </label>
                                <label class="form-group has-float-label mb-4">
                                    <select class="form-control select2-single" name="organization_size_id" data-width="100%">
                                        <option value=""></option>
                                        <?php foreach ($organization_sizes as $key => $organization_size) { ?>
                                            <option value="<?php echo $organization_size['id']; ?>" <?php echo ($organization_size['id'] == $this->input->post('organization_size_id')) ? 'selected' : ''; ?>><?php echo $organization_size['size']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('organization_size_id'); ?>
                                    <span>Organization Size</span>
                                </label>
                                <label class="form-group has-float-label mb-4">
                                    <select class="form-control select2-single" name="organization_type_id" data-width="100%">
                                        <option value=""></option>
                                        <?php foreach ($organization_types as $key => $organization_type) { ?>
                                            <option value="<?php echo $organization_type['id']; ?>" <?php echo ($organization_type['id'] == $this->input->post('organization_type_id')) ? 'selected' : ''; ?>><?php echo $organization_type['title']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('organization_type_id'); ?>
                                    <span>Organization Type</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">UPDATE</button>
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