<?php

namespace frontend\controllers;

use common\models\BonusSearch;
use common\models\CreateTransactionDeduct;
use common\models\TransactionSearch;
use common\models\User;
use frontend\models\UploadForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * User information.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $file = new UploadForm();

        if (Yii::$app->request->isPost && $file->loadToRead()) {
            $this->redirect(['user/transaction']);
        }

        return $this->render('index', [
            'model' => $this->findModel(),
            'file' => $file,
        ]);
    }

    /**
     * User Transactions.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionTransaction(): string
    {
        $model = $this->findModel();

        $searchModel = new TransactionSearch(
            [
                'user_id' => $model->id,
            ],
        );

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('transaction', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * User Bonus.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBonus()
    {
        $model = $this->findModel();

        $searchModel = new BonusSearch(['user_id' => $model->id]);

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('bonus', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = User::findOne(['id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeductTransaction()
    {
        $model = new CreateTransactionDeduct(['user' => $this->findModel()]);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['user/transaction']);
        }

        return $this->render('deduct', [
            'model' => $model,
        ]);
    }
}
