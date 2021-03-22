<div class="col-md-12">
    <div class="bd-example loginpage mb-3">
        <div role="alert">
            <h2 class="alert-heading"><?php echo $flow['name'] ?></h2>
            <?php echo $flow['summary']; ?>
            <hr>
            <form method="post" action="<?php echo site_url('flow/start/'.$flow['hash']); ?>">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input class="form-control" type="text" required name="name" value="<?php echo $this->input->post('name'); ?>" />
                            <?php echo form_error('name'); ?>
                            <span>Name</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input class="form-control" type="email" required name="email" value="<?php echo $this->input->post('email'); ?>" />
                            <?php echo form_error('email'); ?>
                            <span>Email</span>
                        </label>
                    </div>
                </div>
                <div class="clearfix">
                    <button class="btn btn-md btn-primary btn-shadow">Start</button>
                </div>
            </form>
        </div>
    </div>
</div>