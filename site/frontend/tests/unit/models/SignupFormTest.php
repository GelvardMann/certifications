<?php
namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use common\modules\user\models\SignupForm;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new \common\modules\user\models\SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();
        expect($user)->true();

        /** @var \common\modules\user\models\User $user */
        $user = $this->tester->grabRecord('common\modules\user\models\User', [
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'status' => \common\modules\user\models\User::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        expect($mail)->isInstanceOf('yii\mail\MessageInterface');
        expect($mail->getTo())->hasKey('some_email@example.com');
        expect($mail->getFrom())->hasKey(\Yii::$app->params['supportEmail']);
        expect($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        expect($mail->toString())->stringContainsString($user->verification_token);
    }

    public function testNotCorrectSignup()
    {
        $model = new \common\modules\user\models\SignupForm([
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));

        expect($model->getFirstError('username'))
            ->equals('This username has already been taken.');
        expect($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }
}
