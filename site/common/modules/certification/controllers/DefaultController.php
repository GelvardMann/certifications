<?php

namespace common\modules\certification\controllers;

use common\modules\certification\models\CertificationsList;
use common\modules\certification\models\QuestionList;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `certification` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function actionIndex()
    {
        $certificationsList = CertificationsList
            ::find()->indexBy('id')->all();
        return $this->render('index',
            [
                'certificationsList' => $certificationsList,
            ]);
    }

    /**
     * Create array for questions and answers or results of test
     * @param $id
     * @return string
     */

    public function actionRun($id)
    {
        $model = new QuestionList();
        if (Yii::$app->request->post()) {
            $questionId = Yii::$app->request->post('question_id');
            $userAnswers = Yii::$app->request->post('userAnswer');
            foreach ($userAnswers as $index => $item) {
                $_SESSION['certification'][$questionId]['result'][$index] = $item;
            }
        }
        if (!isset($_SESSION['certification'])) {
            $session = Yii::$app->session;
            $session->open();
            $_SESSION['testId'] = $id;
            $questions = $model->generateQuestion($id);
            $answers = $model->generateAnswers($questions);
            $model->makeSessionArray($questions, $answers, $id);

        }

        if (empty($_SESSION['certification'])) {
            return $this->render('certification',
                [
                    'testId' => $id,
                ]);
        } else {
            foreach ($_SESSION['certification'] as $question) {
                if ($question['result'] == null) {
                    return $this->render('certification',
                        [
                            'id' => $question['id'],
                            'testId' => $id,
                        ]);
                }
            }
        }
        $resultCertification = $model->getResult();
        return $this->render('results',
            [
                'results' => $resultCertification
                ,
            ]);
    }

    public function actionClose()
    {

        $session = Yii::$app->session;
        $session->destroy();
        return $this->redirect('index');
    }
}
