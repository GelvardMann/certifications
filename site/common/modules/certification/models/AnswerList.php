<?php

namespace common\modules\certification\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%answer_list}}".
 *
 * @property int $id
 * @property string $answer
 * @property int $question_id
 * @property int $correct
 *
 * @property QuestionList $question
 */
class AnswerList extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%answer_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer', 'question_id', 'correct'], 'required'],
            [['question_id', 'correct'], 'integer'],
            [['answer'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionList::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'answer' => Yii::t('app', 'Answer'),
            'question_id' => Yii::t('app', 'Question ID'),
            'correct' => Yii::t('app', 'Correct'),
        ];
    }

    /**
     * Gets query for [[Question]].
     *
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(QuestionList::className(), ['id' => 'question_id']);
    }
}
