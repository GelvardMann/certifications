<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\user\models\profile\DepartmentList;
use common\modules\user\models\profile\Shops;
use common\modules\user\models\profile\Positions;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\profile\UsersProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_id')->dropDownList(DepartmentList::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shop_id')->dropDownList(Shops::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

    <?= $form->field($model, 'position_id')->dropDownList(Positions::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
