<?php $this->load->view('admin/layout/alert'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Flows</h1>
            <div class="top-right-button-container">
                <a class="btn btn-primary btn-lg top-right-button" href="<?php echo site_url('admin/flow/add'); ?>">ADD NEW</a>
            </div>
            <div class="mb-2">
                <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"
                    role="button" aria-expanded="true" aria-controls="displayOptions">
                    Display Options
                    <i class="simple-icon-arrow-down align-middle"></i>
                </a>
                <div class="collapse dont-collapse-sm" id="displayOptions">
                    <div class="d-block d-md-inline-block">
                        <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                            <input class="form-control" placeholder="Search Table" id="searchDatatable">
                        </div>
                    </div>
                    <div class="float-md-right dropdown-as-select" id="pageCountDatatable">
                        <span class="text-muted text-small">Displaying 1-10 of 40 items </span>
                        <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            10
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">5</a>
                            <a class="dropdown-item active" href="#">10</a>
                            <a class="dropdown-item" href="#">20</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4 data-table-rows data-tables-hide-filter">
            <table id="datatableRows" class="data-table responsive nowrap"
                data-order="[[ 1, &quot;desc&quot; ]]">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Steps</th>
                        <th>Submissions</th>
                        <th class="empty" width="20%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flows as $key => $flow) { ?>
                        <tr>
                            <td>
                                <p class="list-item-heading"><?php echo $flow['name']; ?></p>
                            </td>
                            <td>
                                <p class="text-muted"><?php echo $flow['type']; ?></p>
                            </td>
                            <td>
                                <p class="text-muted"><?php echo $flow['total_steps']; ?></p>
                            </td>
                            <td>
                                <a href="<?php echo site_url('admin/submissions?flow_id='.$flow['id']); ?>">
                                    <?php if($flow['total_submissions']) { ?>
                                        <span class="badge badge-pill badge-success"><?php echo $flow['total_submissions']; ?></span>
                                    <?php } else { ?>
                                        <span class="badge badge-pill badge-danger"><?php echo $flow['total_submissions']; ?></span>
                                    <?php } ?>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm mr-1" target="_blank" href="<?php echo site_url('flow/'.$flow['hash']); ?>">View</a>
                                <a class="btn btn-primary btn-sm mr-1" href="<?php echo site_url('admin/flow/edit/'.$flow['id']); ?>">Edit</a>
                                <a class="btn btn-secondary btn-sm mr-1" href="<?php echo site_url('admin/flow/steps/'.$flow['id']); ?>">Steps</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo site_url('admin/flow/delete/'.$flow['id']); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>