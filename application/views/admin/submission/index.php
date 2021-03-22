<?php $this->load->view('admin/layout/alert'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Submissions</h1>
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
                        <th>Flow</th>
                        <th>User</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th class="empty" width="20%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $key => $submission) { ?>
                        <tr>
                            <td>
                                <p class="list-item-heading"><?php echo $submission['flow']; ?></p>
                            </td>
                            <td>
                                <p class="list-item-heading"><?php echo $submission['name']; ?><br><a href="mailto:<?php echo $submission['email']; ?>"><?php echo $submission['email']; ?></a></p>
                            </td>
                            <td>
                                <p class="text-muted"><?php echo convert_db_time($submission['start_time'], 'h:i A'); ?> - <?php echo convert_db_time($submission['end_time'], 'h:i A'); ?></p>
                            </td>
                            <td>
                                <p class="text-muted"><?php echo convert_db_time($submission['created_on']); ?></p>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm mr-1" href="<?php echo site_url('admin/submission/view/'.$submission['id']); ?>">View</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>