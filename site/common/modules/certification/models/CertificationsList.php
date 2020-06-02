<?php

namespace common\modules\certification\models;

use Yii;
use yii\db\ActiveQuery;
use common\modules\user\models\User;

/**
 * This is the model class for table "{{%tests_list}}".
 *
 * @property int $id
 * @property string $name
 * @property int $count_questions
 * @property int $author_id
 * @property int $department_id
 *
 * @property QuestionList[] $questionLists
 * @property \common\modules\user\models\User $author
* // * @property DepartmentList $department
 */
class CertificationsList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%certifications_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'count_questions', 'author_id', 'department_id'], 'required'],
            [['count_questions', 'author_id', 'department_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\modules\user\models\User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepartmentList::className(), 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'count_questions' => Yii::t('app', 'Count Questions'),
            'author_id' => Yii::t('app', 'Author ID'),
            'department_id' => Yii::t('app', 'Department ID'),
        ];
    }

    /**
     * Gets query for [[QuestionLists]].
     *
     * @return ActiveQuery
     */
    public function getQuestionLists()
    {
        return $this->hasMany(QuestionList::className(), ['test_id' => 'id']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

//    /**
//     * Gets query for [[Department]].
//     *
//     * @return ActiveQuery
//     */
//    public function getDepartment()
//    {
//        return $this->hasOne(DepartmentList::className(), ['id' => 'department_id']);
//    }
}
