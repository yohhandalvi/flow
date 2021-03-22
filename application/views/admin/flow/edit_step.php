<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Update Flow Step</h1>
            <div class="separator mb-5"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Step details</h5>
                    <form method="post">
                        <label class="form-group has-float-label">
                            <input class="form-control" name="step" value="<?php echo ($this->input->post('step')) ? $this->input->post('step') : $step['step']; ?>" />
                            <?php echo form_error('step'); ?>
                            <span>Name</span>
                        </label>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>