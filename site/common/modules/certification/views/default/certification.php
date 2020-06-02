<?php

use common\modules\certification\models\AnswerList;
use common\modules\certification\models\CertificationsList;
use common\modules\certification\models\QuestionList;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $answers AnswerList */
/* @var $questions QuestionList */
/* @var $testId */
/* @var $id */
?>

<div class="tests-list-form">
    <?php if ($_SESSION['testId'] == $testId) { ?>
        <?php if (!empty($_SESSION['certification'])) : ?>
            <h2><?= $_SESSION['certification'][$id]['question_title'] ?></h2>
            <h4><?= $_SESSION['certification'][$id]['question'] ?></h4>
            <div class="form-group">
                <?= Html::beginForm(['run', 'id' => $testId], 'POST'); ?>
                <?= Html::hiddenInput('question_id', $id) ?>
                <?php foreach ($_SESSION['certification'][$id]['answers'] as $answer) { ?>
                    <div class="form-group">
                        <?php $answersId = $answer['id'] ?>
                        <?= Html::label($answer['answer'], $answer['id'], ['class' => 'control-label']) ?>
                        <?= Html::checkbox("userAnswer[$answersId]", false) ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <?= Html::submitButton('Далее', ['class' => 'btn btn-success']) ?>
                </div>

                <?php Html::endForm(); ?>
            </div>
        <?php else: ?>
            <h3>Тест не заполнен!</h3>
        <?php endif; ?>
    <?php } else { ?>
        <h4>Вы не закончили тест - <?= CertificationsList::findOne($testId)->name ?></h4>
        <?=Html::a('Продолжить', ['certification/run', 'id' => $_SESSION['testId']]) ?>
    <?php } ?>
</div>