<?php $this->load->view('admin/layout/alert'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Publish Flow Steps - <?php echo  $flow['name']; ?></h1>
            <div class="separator mb-5"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" id="id" value="<?php echo $flow['id']; ?>">
                <input type="hidden" name="input" value="1">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <?php if(!empty($flow['steps'])) { ?>
                                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                                        <?php foreach ($flow['steps'] as $key => $step) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo ($this->input->get('step') == 'tab-'.$step['id']) ? 'active' : '' ?>" id="<?php echo 'tab-'.$step['id']; ?>-line" data-toggle="tab" href="#<?php echo 'tab-'.$step['id']; ?>" role="tab" aria-controls="<?php echo 'tab-'.$step['id']; ?>" aria-selected="true"><i class="feather icon-home mr-2"></i><?php echo $step['step']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content" id="defaultTabContentLine">
                                        <?php foreach ($flow['steps'] as $key => $step) { ?>
                                            <div class="tab-pane fade <?php echo ($this->input->get('step') == 'tab-'.$step['id']) ? 'active show' : '' ?>" id="<?php echo 'tab-'.$step['id']; ?>" role="tabpanel" aria-labelledby="<?php echo 'tab-'.$step['id']; ?>-line">
                                                <?php $type = $step['id']; ?>
                                                <?php if(!empty($step['questions'])) { ?>
                                                    <?php foreach ($step['questions'] as $question) { ?>
                                                        <fieldset>
                                                            <?php $key = "i_".$question['id']; ?>
                                                            <div class="parent-box">
                                                                <label>Question</label>
                                                                <button type="button" class="btn btn-outline-danger btn-xs question_remove mb-3 float-right">Delete Question</button>
                                                                <div class="form-group for-shop">
                                                                    <select name="<?php echo $type; ?>[<?php echo $key; ?>][type]" class="type_change form-control">
                                                                        <option value="">-- Type --</option>
                                                                        <?php
                                                                            $value = 'text';
                                                                            $selected = "";
                                                                            if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]'] == $value)
                                                                                $selected = 'selected';
                                                                            else if (isset($question['type']) && $question['type'] == $value)
                                                                                $selected = 'selected';
                                                                        ?>
                                                                        <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                                                                        <?php
                                                                            $value = 'image';
                                                                            $selected = "";
                                                                            if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]'] == $value)
                                                                                $selected = 'selected';
                                                                            else if (isset($question['type']) && $question['type'] == $value)
                                                                                $selected = 'selected';
                                                                        ?>
                                                                        <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group for-shop">
                                                                    <?php
                                                                        $value = 'text';
                                                                        $show = 'display: none;';
                                                                        if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]'] == $value)
                                                                            $show = 'display: block;';
                                                                        else if (isset($question['type']) && $question['type'] == $value)
                                                                            $show = 'display: block;';
                                                                    ?>
                                                                    <div class="text" style="<?php echo $show; ?>">
                                                                        <textarea placehlder="Question" name="<?php echo $type; ?>[<?php echo $key; ?>][question]" class="form-control"><?= ($this->input->post('<?php echo $type; ?>[<?php echo $key; ?>][question]')) ? $this->input->post('<?php echo $type; ?>[<?php echo $key; ?>][question]') : (isset($question['question']) ? $question['question'] : "") ?></textarea>
                                                                    </div>
                                                                    <?php
                                                                        $value = 'image';
                                                                        $show = 'display: none;';
                                                                        if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][type]'] == $value)
                                                                            $show = 'display: block;';
                                                                        else if (isset($question['type']) && $question['type'] == $value)
                                                                            $show = 'display: block;';
                                                                    ?>
                                                                    <div class="image" style="<?php echo $show; ?>">
                                                                        <?php if (isset($question['type']) && $question['type'] == 'image') { ?>
                                                                            <?php $image = base_url('attachments/questions/' . $question['question']); ?>
                                                                            <img src="<?php echo $image; ?>" width="200px"><br clear="all">
                                                                        <?php } ?>
                                                                        <input type="file" name="<?php echo $type; ?>[<?php echo $key; ?>][question]" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group for-shop">
                                                                    <label>
                                                                        <?php
                                                                            $value = 1;
                                                                            $checked = '';
                                                                            if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][has_options]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][has_options]'] == $value)
                                                                                $checked = 'checked';
                                                                            else if(isset($question['has_options']) && $question['has_options'] == $value)
                                                                                $checked = 'checked';
                                                                        ?>
                                                                        <input type="checkbox" class="option_change" name="<?php echo $type; ?>[<?php echo $key; ?>][has_options]" value="<?php echo $value; ?>" <?php echo $checked; ?>>&nbsp;&nbsp;Has Options?
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                $value = 1;
                                                                $show = 'display: none;';
                                                                if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][has_options]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][has_options]'] == $value)
                                                                    $show = 'display: block;';
                                                                else if(isset($question['has_options']) && $question['has_options'] == $value)
                                                                    $show = 'display: block;';
                                                            ?>
                                                            <div class="options-box" style="<?php echo $show; ?>">
                                                                <?php if(!empty($question['answers'])) { ?>
                                                                    <?php foreach ($question['answers'] as $answer) { ?>
                                                                        <div class="parent-box">
                                                                            <?php $akey = "i_".$answer['id']; ?>
                                                                            <hr>
                                                                            <label>Answer</label>
                                                                            <button type="button" class="btn btn-outline-danger btn-xs answer_remove mb-3 float-right">Delete Answer</button>
                                                                            <div class="form-group for-shop">
                                                                                <select name="<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]" class="type_change form-control">
                                                                                    <option value="">-- Type --</option>
                                                                                    <?php
                                                                                        $value = 'text';
                                                                                        $selected = "";
                                                                                        if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]'] == $value)
                                                                                            $selected = 'selected';
                                                                                        else if (isset($answer['type']) && $answer['type'] == $value)
                                                                                            $selected = 'selected';
                                                                                    ?>
                                                                                    <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                                                                                    <?php
                                                                                        $value = 'image';
                                                                                        $selected = "";
                                                                                        if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]'] == $value)
                                                                                            $selected = 'selected';
                                                                                        else if (isset($answer['type']) && $answer['type'] == $value)
                                                                                            $selected = 'selected';
                                                                                    ?>
                                                                                    <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group for-shop">
                                                                                <?php
                                                                                    $value = 'text';
                                                                                    $show = 'display: none;';
                                                                                    if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][type]'] == $value)
                                                                                        $show = 'display: block;';
                                                                                    else if (isset($answer['type']) && $answer['type'] == $value)
                                                                                        $show = 'display: block;';
                                                                                ?>
                                                                                <div class="text" style="<?php echo $show; ?>">
                                                                                    <textarea placehlder="Answer" name="<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][answer]" class="form-control"><?= ($this->input->post('<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][answer]')) ? $this->input->post('<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][answer]') : (isset($question['question']) ? $answer['answer'] : "") ?></textarea>
                                                                                </div>
                                                                                <?php
                                                                                    $value = 'image';
                                                                                    $show = 'display: none;';
                                                                                    if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][answer]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][answer]'] == $value)
                                                                                        $show = 'display: block;';
                                                                                    else if (isset($answer['type']) && $answer['type'] == $value)
                                                                                        $show = 'display: block;';
                                                                                ?>
                                                                                <div class="image" style="<?php echo $show; ?>">
                                                                                    <?php if (isset($answer['type']) && $answer['type'] == 'image') { ?>
                                                                                        <?php $image = base_url('attachments/answers/' . $answer['answer']); ?>
                                                                                        <img src="<?php echo $image; ?>" width="50px"><br clear="all">
                                                                                    <?php } ?>
                                                                                    <input type="file" name="<?php echo $type; ?>[<?php echo $key; ?>][answers][<?php echo $akey; ?>][answer]" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group for-shop">
                                                                                <label>
                                                                                    <?php
                                                                                        $value = $akey;
                                                                                        $checked = '';
                                                                                        if(isset($_POST['<?php echo $type; ?>[<?php echo $key; ?>][right_answer]']) && $_POST['<?php echo $type; ?>[<?php echo $key; ?>][right_answer]'])
                                                                                            $checked = 'checked';
                                                                                        else if (isset($answer['right_answer']) && $answer['right_answer'])
                                                                                            $checked = 'checked';
                                                                                    ?>
                                                                                    <input type="radio" name="<?php echo $type; ?>[<?php echo $key; ?>][right_answer]" value="<?php echo $value; ?>" <?php echo $checked; ?>>&nbsp;&nbsp;Right Answer
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <div class="parent-box">
                                                                    <hr>
                                                                    <button type="button" class="btn btn-outline-success btn-xs answer_add mb-3" data-type="<?php echo $type; ?>" data-question="<?php echo $key; ?>" data-answer="0">Add Answer</button>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    <?php } ?>
                                                <?php } ?>
                                                <div class="parent-box">
                                                    <button type="button" class="btn btn-outline-success question_add" data-type="<?php echo $type; ?>" data-question="0" data-answer="0">Add Question</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    Please add steps before adding questions to it.
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-shadow mr-2">Publish</button>
                    <a href="<?= base_url('admin/flow/steps/'.$flow['id']) ?>" class="btn btn-secondary btn-lg btn-shadow float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="tpl-answer">
    <div class="parent-box">
        <hr>
        <label>Answer</label>
        <button type="button" class="btn btn-outline-danger btn-xs answer_remove mb-3 float-right">Delete Answer</button>
        <div class="form-group for-shop">
            <select name="{type}[{key}][answers][{akey}][type]" class="type_change form-control">
                <option value="">-- Type --</option>
                <?php
                    $value = 'text';
                    $selected = "";
                ?>
                <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                <?php
                    $value = 'image';
                    $selected = "";
                ?>
                <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
            </select>
        </div>
        <div class="form-group for-shop">
            <?php
                $value = 'text';
                $show = 'display: none;';
            ?>
            <div class="text" style="<?php echo $show; ?>">
                <textarea placeholder="Answer" name="{type}[{key}][answers][{akey}][answer]" class="form-control"></textarea>
            </div>
            <?php
                $value = 'image';
                $show = 'display: none;';
            ?>
            <div class="image" style="<?php echo $show; ?>">
                <input type="file" name="{type}[{key}][answers][{akey}][answer]" class="form-control">
            </div>
        </div>
        <div class="form-group for-shop">
            <label>
                <?php
                    $value = 1;
                    $checked = '';
                ?>
                <input type="radio" name="{type}[{key}][right_answer]" value="{akey}" <?php echo $checked; ?>>&nbsp;&nbsp;Right Answer
            </label>
        </div>
    </div>
</template>

<template id="tpl-question">
    <fieldset>
        <div class="parent-box">
            <label>Question</label>
            <button type="button" class="btn btn-outline-danger btn-xs question_remove mb-3 float-right">Delete Question</button>
            <div class="form-group for-shop">
                <select name="{type}[{key}][type]" class="type_change form-control">
                    <option value="">-- Type --</option>
                    <?php
                        $value = 'text';
                        $selected = "";
                    ?>
                    <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                    <?php
                        $value = 'image';
                        $selected = "";
                    ?>
                    <option value="<?php echo $value; ?>" <?= $selected; ?>><?php echo ucfirst($value); ?></option>
                </select>
            </div>
            <div class="form-group for-shop">
                <?php
                    $value = 'text';
                    $show = 'display: none;';
                ?>
                <div class="text" style="<?php echo $show; ?>">
                    <textarea placehlder="Question" name="{type}[{key}][question]" class="form-control"></textarea>
                </div>
                <?php
                    $value = 'image';
                    $show = 'display: none;';
                ?>
                <div class="image" style="<?php echo $show; ?>">
                    <input type="file" name="{type}[{key}][question]" class="form-control">
                </div>
            </div>
            <div class="form-group for-shop">
                <label>
                    <?php
                        $value = 1;
                        $checked = '';
                    ?>
                    <input type="checkbox" class="option_change" name="{type}[{key}][has_options]" value="<?php echo $value; ?>" <?php echo $checked; ?>>&nbsp;&nbsp;Has Options?
                </label>
            </div>
        </div>
        <?php
            $value = 1;
            $show = 'display: none;';
        ?>
        <div class="options-box" style="<?php echo $show; ?>">
            <div class="parent-box">
                <hr>
                <button type="button" class="btn btn-outline-success btn-xs mb-3 answer_add" data-type="{type}" data-question="{key}" data-answer="0">Add Answer</button>
            </div>
        </div>
    </fieldset>
</template>

<script>
    $(document).ready(function() {
        $(document).on("change", "select.type_change", function(){
            var _this = $(this);
            var value = _this.children("option:selected").val();
            _this.parents('.parent-box').find('.text').hide();
            _this.parents('.parent-box').find('.image').hide();
            _this.parents('.parent-box').find('.'+value).show();
        });

        $(document).on("change", "input.option_change", function(){
            var _this = $(this);
            if(_this.prop("checked")) {
                _this.parents('fieldset').find('.options-box').show();
            } else {
                _this.parents('fieldset').find('.options-box').hide();
            }
        });

        $(document).on("click", "button.question_add", function(){
            var _this = $(this);
            var type = _this.attr('data-type');
            var key = _this.attr('data-question');
            var akey = _this.attr('data-answer');
            var html = $("#tpl-question").html();
            var html = html.replace(/{type}/g, type);
            var html = html.replace(/{key}/g, key);
            var html = html.replace(/{akey}/g, akey);
            _this.parents('.parent-box').before(html);
            key++;
            _this.attr('data-question', key);
        });

        $(document).on("click", "button.answer_add", function(){
            var _this = $(this);
            var type = _this.attr('data-type');
            var key = _this.attr('data-question');
            var akey = _this.attr('data-answer');
            var html = $("#tpl-answer").html();
            var html = html.replace(/{type}/g, type);
            var html = html.replace(/{key}/g, key);
            var html = html.replace(/{akey}/g, akey);
            _this.parents('.parent-box').before(html);
            akey++;
            _this.attr('data-answer', akey);
        });

        $(document).on("click", "button.question_remove", function(){
            var _this = $(this);
            _this.parents('fieldset').remove();
        });

        $(document).on("click", "button.answer_remove", function(){
            var _this = $(this);
            _this.parents('.parent-box').remove();
        });
    })
</script>

<style>
    fieldset {
        border: 1px dashed #ccc !important;
        padding: 15px !important;
        padding-bottom: 0px !important;
        margin-bottom: 20px !important;
    }
    .btn-success {
        margin-bottom: 20px; 
    }
    .btn-danger {
        margin-bottom: 15px; 
    }
</style>