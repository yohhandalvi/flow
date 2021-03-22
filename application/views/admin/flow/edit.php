<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Update Flow</h1>
            <div class="separator mb-5"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Flow details</h5>
                    <form method="post">
                        <label class="form-group has-float-label">
                            <input class="form-control" name="name" value="<?php echo ($this->input->post('name')) ? $this->input->post('name') : $flow['name']; ?>" />
                            <?php echo form_error('name'); ?>
                            <span>Name</span>
                        </label>
                        <label class="form-group has-float-label">
                            <select class="form-control select2-single" data-width="100%" name="flow_type_id">
                                <option value=""></option>
                                <?php foreach ($flow_types as $key => $flow_type) { ?>
                                    <?php
                                        $selected = ''; 
                                        if($this->input->post('flow_type_id') == $flow_type['id'])
                                            $selected = 'selected';
                                        else if($flow['flow_type_id'] == $flow_type['id'])
                                            $selected = 'selected';
                                    ?>
                                    <option value="<?php echo $flow_type['id']; ?>" <?php echo $selected; ?>><?php echo $flow_type['type']; ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('flow_type_id'); ?>
                            <span>Type</span>
                        </label>
                        <label class="form-group has-float-label">
                            <textarea name="summary" id="ckEditorClassic"><?php echo ($this->input->post('summary')) ? $this->input->post('summary') : $flow['summary']; ?></textarea>
                            <?php echo form_error('summary'); ?>
                            <span>Summary</span>
                        </label>
                        <label class="form-group has-float-label">
                            <input type="date" class="form-control" name="flow_date" value="<?php echo ($this->input->post('flow_date')) ? $this->input->post('flow_date') : $flow['flow_date']; ?>" />
                            <?php echo form_error('flow_date'); ?>
                            <span>Date (Optional - leave blank for open flow)</span>
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-group has-float-label">
                                    <input type="time" class="form-control" name="start_time" value="<?php echo ($this->input->post('start_time')) ? $this->input->post('start_time') : $flow['start_time']; ?>" />
                                    <?php echo form_error('start_time'); ?>
                                    <span>Start Time (Optional)</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-group has-float-label">
                                    <input type="time" class="form-control" name="end_time" value="<?php echo ($this->input->post('end_time')) ? $this->input->post('end_time') : $flow['end_time']; ?>" />
                                    <?php echo form_error('end_time'); ?>
                                    <span>End Time (Optional)</span>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>