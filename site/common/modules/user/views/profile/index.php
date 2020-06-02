<?php

use common\modules\user\models\profile\Shops;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\profile\UsersProfile */

if (isset($model->name)) {
    $this->title = $model->name;
} else {
    $this->title = Yii::$app->user->identity->username;
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php if ($model) : ?>
    <div class="users-profile-view">
        <div class="row">
            <div class="col-sm-8">
                <?php if (!empty($model)) : ?>
                    <h3><?= $model->surname ?>
                        <?= $model->name ?>
                        <?= $model->middle_name ?>
                    </h3>
                    <p>
                        <?= Html::a('Редактировать профиль', ['update'], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Смена пароля', ['/user/request-password-reset'], ['class' => 'btn btn-primary']) ?>
                    </p>
                <?php else : ?>
                    <h2><?= $this->title ?></h2>
                <?php endif; ?>
            </div>
            <div class="col-sm-4">
                <?php if (!empty($model->image)) : ?>
                    <a href="<?= Url::to('/profile/upload/') ?>">
                        <?= \yii\helpers\Html::img(Url::to('/uploads/images/' . $model->user_id . '/' . $model->image),
                            [
                                'alt' => 'Image not found',
                                'class' => 'profile-photo'
                            ]) ?>
                    </a>
                <?php else : ?>
                    <a href="<?= Url::to('/profile/upload/') ?>">
                        <?= \yii\helpers\Html::img(Url::to('/uploads/images/noImage.jpg'),
                            [
                                'alt' => 'Image not found',
                                'class' => 'profile-photo'
                            ]) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'user_id',
                    'value' => function ($model) {
                        return \common\modules\user\models\User::findOne($model->user_id)->username;
                    }
                ],
                [
                    'attribute' => 'email',
                    'value' => function ($model) {
                        return \common\modules\user\models\User::findOne($model->user_id)->email;
                    }
                ],
                [
                    'attribute' => 'department_id',
                    'value' => function ($model) {
                        return \common\modules\user\models\profile\Positions::findOne($model->department_id)->name;
                    }
                ],
                'surname',
                'name',
                'middle_name',
                [
                    'attribute' => 'shop_id',
                    'value' => function ($model) {
                        $shops = Shops::findOne($model->shop_id);
                        return $shops->name . '(' . $shops->city . ')';
                    }
                ],
                [
                    'attribute' => 'position_id',
                    'value' => function ($model) {
                        return \common\modules\user\models\profile\Positions::findOne($model->position_id)->name;
                    }
                ],
                'created_at:date',
                'updated_at:date',
            ],
        ]) ?>

    </div>
<?php else : ?>
    <h2>empty</h2>
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
<?php endif; ?>
