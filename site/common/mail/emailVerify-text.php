<?php

/* @var $this yii\web\View */

use common\modules\user\models\User;

/* @var $user User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['user/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
