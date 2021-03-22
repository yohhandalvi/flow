<section class="mt-5 mb-5">
    <form method="post">
        <div class="row">
            <div class="col-md-12">
                <h2 class="alert-heading"><?php echo $flow['name'] ?></h2><hr>
                <p class="list-item-heading mb-4"><?php echo $step['step']; ?></p>
                <div class="row">
                    <div class="col-md-12">
                        <?php if(!empty($step['questions'])) { ?>
                            <?php foreach ($step['questions'] as $key => $question) { ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <?php if($question['type'] == "image") { ?>
                                            <?php $image = base_url('attachments/questions/' . $question['question']); ?>
                                            <img src="<?php echo $image; ?>" style="margin-bottom: 30px;"><br clear="all">
                                        <?php } else { ?>
                                            <h5><?php echo $question['question']; ?></h5>
                                        <?php } ?>
                                        <?php if($question['has_options'] && !empty($question['answers'])) { ?>
                                            <div class="row mt-3">
                                                <?php foreach ($question['answers'] as $key => $answer) { ?>
                                                    <div class="col-md-6">
                                                        <?php
                                                            $checked = "";
                                                            if($this->input->post() && $this->input->post($question['id']) == $answer['id'])
                                                                $checked = "checked";
                                                            else if(!empty($user_submission['answers'])) {
                                                                foreach ($user_submission['answers'] as $user_answer) {
                                                                    if($user_answer['flow_question_id'] == $question['id'] && $user_answer['answer'] == $answer['id']) {
                                                                        $checked = "checked";
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio<?php echo $answer['id']; ?>" name="<?php echo $question['id']; ?>" class="custom-control-input" value="<?php echo $answer['id']; ?>" <?php echo $checked; ?>>
                                                            <label class="custom-control-label" for="customRadio<?php echo $answer['id']; ?>">
                                                                <?php if($answer['type'] == "image") { ?>
                                                                    <?php $image = base_url('attachments/answers/' . $answer['answer']); ?>
                                                                    <img src="<?php echo $image; ?>">
                                                                <?php } else { ?>
                                                                    <?php echo $answer['answer']; ?>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <?php
                                                $value = null;
                                                if($this->input->post($question['id']))
                                                    $value = $question['id'];
                                                else if(!empty($user_submission['answers'])) {
                                                    foreach ($user_submission['answers'] as $user_answer) {
                                                        if($user_answer['flow_question_id'] == $question['id']) {
                                                            $value = $user_answer['answer'];
                                                        }
                                                    }
                                                }
                                            ?>
                                            <textarea class="form-control mt-3" name="<?php echo $question['id']; ?>"><?php echo $value; ?></textarea>
                                        <?php } ?>
                                        <?php echo form_error($question['id']); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="col-md-12">
                                <h4 class="alert-heading">Go right ahead!</h4>
                                <input type="hidden" name="riddles">
                            </div>
                        <?php } ?>
                        <button class="btn btn-md btn-primary btn-shadow">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    textarea {
        height: 75px !important;
        margin-top: 5px !important;
    }
    img {
        max-width: 100%;
    }
</style>