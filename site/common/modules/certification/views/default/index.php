<?php

use common\modules\certification\models\CertificationsList;
use yii\helpers\Url;

/* @var $certificationsList CertificationsList */
/* @var $this yii\web\View */
?>

<h1>exam/index</h1>
<ul>
    <?php foreach ($certificationsList as $certification) { ?>
        <li>
            <?= \yii\helpers\Html::a($certification->name, Url::toRoute(['/certification/run', 'id' => $certification->id])) ?>
        </li>
    <?php } ?>
</ul>
