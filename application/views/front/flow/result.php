<div class="col-md-12">
    <div class="bd-example loginpage mb-3">
        <div role="alert">
            <h2 class="alert-heading"><?php echo $flow['name'] ?></h2>
            <p class="list-item-heading mb-4">Thank you for submitting the <?php echo strtolower($flow['type']); ?>.</p>
            <hr>
            <p class="list-item-heading mb-3">Check your answers down below.</p>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <?php foreach ($flow['steps'] as $key => $step) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($key == 0) ? 'active' : '' ?>" id="<?php echo 'tab-'.$step['id']; ?>-line" data-toggle="tab" href="#<?php echo 'tab-'.$step['id']; ?>" role="tab" aria-controls="<?php echo 'tab-'.$step['id']; ?>" aria-selected="true"><?php echo $step['step']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach ($flow['steps'] as $key => $step) { ?>
                            <div class="tab-pane fade <?php echo ($key == 0) ? 'active show' : '' ?>" id="<?php echo 'tab-'.$step['id']; ?>" role="tabpanel" aria-labelledby="<?php echo 'tab-'.$step['id']; ?>-line">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if(!empty($step['questions'])) { ?>
                                            <?php foreach ($step['questions'] as $key => $question) { ?>
                                                <?php 
                                                    $view_answer = null; 
                                                    $your_answer = null; 
                                                    $right_answer = null; 
                                                    $view_right_answer = null; 
                                                ?>
                                                <?php if($question['has_options'] && !empty($question['answers'])) { ?>
                                                    <?php foreach ($question['answers'] as $key => $answer) { ?>
                                                        <?php
                                                            if($answer['right_answer']) {
                                                                $right_answer = $answer['id'];
                                                                if($answer['type'] == "image") {
                                                                    $image = base_url('attachments/answers/' . $answer['answer']);
                                                                    $view_right_answer = '<br><img src="'.$image.'">';
                                                                } else {
                                                                    $view_right_answer = $answer['answer'];
                                                                }
                                                            }
                                                            if(!empty($user_submission['answers'])) {
                                                                foreach ($user_submission['answers'] as $user_answer) {
                                                                    if($user_answer['flow_question_id'] == $question['id'] && $user_answer['answer'] == $answer['id']) {
                                                                        $your_answer = $answer['id'];
                                                                        if($answer['type'] == "image") {
                                                                            $image = base_url('attachments/answers/' . $answer['answer']);
                                                                            $view_answer = '<br><img src="'.$image.'">';
                                                                        } else {
                                                                            $view_answer = $answer['answer'];
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php
                                                        if(!empty($user_submission['answers'])) {
                                                            foreach ($user_submission['answers'] as $user_answer) {
                                                                if($user_answer['flow_question_id'] == $question['id']) {
                                                                    $view_answer = $user_answer['answer'];
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                <?php } ?>
                                                <?php 
                                                    if($right_answer) {
                                                        $class = ($your_answer !== null && $your_answer == $right_answer) ? 'success' : 'danger';       
                                                    } else {
                                                        $class = 'primary';
                                                    }
                                                ?>
                                                <div class="alert alert-<?php echo $class; ?> p-4 mt-4 mb-0">
                                                    <?php if($question['type'] == "image") { ?>
                                                        <?php $image = base_url('attachments/questions/' . $question['question']); ?>
                                                        <img src="<?php echo $image; ?>" style="margin-bottom: 30px;"><br clear="all">
                                                    <?php } else { ?>
                                                        <h5><?php echo $question['question']; ?></h5>
                                                    <?php } ?>
                                                    <hr class="my-2">
                                                    <p class="mb-1">Your answer: <?php echo ($view_answer) ? $view_answer : '-- NA --'; ?></p>
                                                    <?php if($your_answer !== null && $your_answer == $right_answer) { ?>
                                                        Correct Answer!
                                                    <?php } ?>
                                                    <?php if($your_answer !== null && $your_answer !== $right_answer && $view_right_answer) { ?>
                                                        Correct Answer: <?php echo $view_right_answer; ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="alert alert-warning p-4 mt-4 mb-0">
                                                No questions were given!
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    img {
        max-width: 100%;
    }
</style>