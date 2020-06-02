<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\profile\UsersProfile */

$this->title = 'Update Users Profile: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
