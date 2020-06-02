<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\profile\UsersProfile */

$this->title = 'Create Users Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
