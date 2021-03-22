<?php $this->load->view('admin/layout/alert'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Flow - Steps</h1>
            <div class="top-right-button-container">
                <a class="btn btn-primary btn-lg top-right-button" href="<?php echo site_url('admin/flow/step/add/'.$flow['id']); ?>">ADD NEW</a>
            </div>
            <div class="separator mb-5"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5 class="mb-4"><?php echo $flow['name']; ?></h5>
            <?php if(!empty($steps)) { ?>
                <div class="row icon-cards-row mb-4">
                    <?php foreach ($steps as $key => $step) { ?>
                        <div class="col-md-3 col-lg-3 col-sm-4 col-6 mb-2" style="">
                            <div class="card">
                                <div class="card-body text-center">
                                    <a href="<?php echo site_url('admin/flow/publish/'.$flow['id'].'?step=tab-'.$step['id']); ?>">
                                        <p class="lead text-center"><?php echo $step['step'] ?></p>
                                        <p class="card-text font-weight-semibold mb-0"><?php echo $step['total_questions'] ?> Questions</p>
                                    </a>
                                </div>
                                <div class="card-footer text-center">
                                    <a class="btn btn-primary btn-sm mr-1" href="<?php echo site_url('admin/flow/step/edit/'.$step['id']); ?>">Edit</a>
                                    <a class="btn btn-danger btn-sm" href="<?php echo site_url('admin/flow/step/delete/'.$step['id']); ?>">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="alert alert-secondary" role="alert">
                    Click on the ADD NEW button to add steps to the flow!
                </div>
            <?php } ?>
        </div>
    </div>
</div>