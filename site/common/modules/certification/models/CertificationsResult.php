<?php

namespace common\modules\certification\models;

use Yii;
use common\modules\user\models\User;

/**
 * This is the model class for table "certifications_result".
 *
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property int $countCorrectlyUserAnswers
 * @property int $points
 * @property int $result
 *
 * @property User $user
 * @property CertificationsList $test
 */
class CertificationsResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certifications_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'test_id', 'countCorrectlyUserAnswers', 'points', 'result'], 'required'],
            [['user_id', 'test_id', 'countCorrectlyUserAnswers', 'points', 'result'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => CertificationsList::className(), 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'test_id' => 'Test ID',
            'countCorrectlyUserAnswers' => 'Count Correctly User Answers',
            'points' => 'Points',
            'result' => 'Result',
        ];
    }



    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(CertificationsList::className(), ['id' => 'test_id']);
    }
}
