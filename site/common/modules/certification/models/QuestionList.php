<?php

namespace common\modules\certification\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\Expression;

/**
 * This is the model class for table "{{%question_list}}".
 *
 * @property int $id
 * @property string $title
 * @property string $question
 * @property int $test_id
 *
 * @property AnswerList[] $answerLists
 * @property CertificationsList $test
 */
class QuestionList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%question_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'question', 'test_id'], 'required'],
            [['test_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['question'], 'string', 'max' => 1500],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestsList::className(), 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'question' => Yii::t('app', 'Question'),
            'test_id' => Yii::t('app', 'Test ID'),
        ];
    }

    /**
     * Gets query for [[AnswerLists]].
     *
     * @return ActiveQuery
     */
    public function getAnswerLists()
    {
        return $this->hasMany(AnswerList::className(), ['question_id' => 'id']);
    }

    /**
     * Gets query for [[Test]].
     *
     * @return ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(CertificationsList::className(), ['id' => 'test_id']);
    }

    /**
     * Gets Question for test
     * @param $id
     * @return array
     */

    public function generateQuestion($id)
    {
        return $questions = $this::find()
            ->where(['test_id' => $id])
            ->orderBy(new Expression('rand()'))
            ->all();
    }

    /**
     * Gets Answers for $questions
     * @param $questions
     * @return array
     */

    public function generateAnswers($questions)
    {
        $answers = null;
        $ids = null;
        foreach ($questions as $question) {
            $ids[] = $question->id;
        }
        if ($ids) {
            $loadItems = AnswerList::find()
                ->where(['question_id' => $ids])
                ->orderBy(new Expression('rand()'))
                ->all();
            if (isset($loadItems)) {
                foreach ($questions as $question) {
                    foreach ($loadItems as $item) {
                        if ($item['question_id'] == $question['id']) {
                            $answers[$question->id][] = $item;
                        }
                    }
                }
            }
        }
        return $answers;
    }

    public function makeSessionArray($questions, $answers, $testId)
    {
        foreach ($questions as $question) {
            if ($question) {
                $_SESSION['certification'][$question->id] =
                    [
                        'id' => $question->id,
                        'question_title' => $question->title,
                        'question' => $question->question,
                    ];
                foreach ($answers[$question->id] as $answer) {
                    $_SESSION['certification'][$question->id]['answers'][$answer->id] =
                        [

                            'id' => $answer->id,
                            'answer' => $answer->answer,
                            'correct' => $answer->correct,

                        ];
                }
            }
            $_SESSION['certification'][$question->id]['result'] = null;
        }

    }

    public function getResult()
    {
        $questions = $_SESSION['certification'];
        $certificationResult = array();
        $countQuestions = 0;

        foreach ($questions as $question) {
            $countQuestions++;
            $certificationResult['questions'][$question['id']]['question'] = $question;
            foreach ($question['answers'] as $answer) {
                if ($answer['correct']) {
                    $certificationResult['questions'][$question['id']]['correctlyAnswers'][$answer['id']] = $answer['answer'];
                }
            }
            foreach ($question['result'] as $index => $result) {
                $certificationResult['questions'][$question['id']]['userAnswers'][$index] = $question['answers'][$index]['answer'];
            }
            if ($certificationResult['questions'][$question['id']] ['correctlyAnswers'] == $certificationResult['questions'][$question['id']]['userAnswers']) {
                $certificationResult['questions'][$question['id']]['correct'] = true;
            } else {
                $certificationResult['questions'][$question['id']]['correct'] = false;
            }
        }
        $correctlyUserAnswers = 0;
        foreach ($certificationResult['questions'] as $question) {
            if ($question['correct']) {
                $correctlyUserAnswers++;
            }
        }
        $certificationResult['testId'] = $_SESSION['testId'];
        $certificationResult['countCorrectlyUserAnswers'] = $correctlyUserAnswers;
        $certificationResult['countQuestions'] = $countQuestions;
        $certificationResult['points'] = number_format($correctlyUserAnswers / $countQuestions * 100);

        $this->saveResult($certificationResult);

        return $certificationResult;
    }

    public function saveResult($certificationResult)
    {
        $model = new CertificationsResult();
        if ($certificationResult) {
            $model->user_id = Yii::$app->user->identity->getId();
            $model->test_id = $certificationResult['testId'];
            $model->countCorrectlyUserAnswers = $certificationResult['countCorrectlyUserAnswers'];
            $model->points = $certificationResult['points'];
            if ($certificationResult['points'] > 85) {
                $model->result = 1;
            } else {
                $model->result = 0;
            }
            $model->save();
        }
    }
}
