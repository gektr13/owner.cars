<?php

namespace backend\controllers;

use common\models\BonusSearch;
use backend\models\CreateTransactionAugment;
use common\models\CreateTransactionDeduct;
use common\models\TransactionSearch;
use backend\models\User;
use backend\models\UserSearch;
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $gridColumns = [
            'id',
            'username',
            'balance',
            'bonus',
            'created_at',
            'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => $gridColumns,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModelTranscation = new TransactionSearch(
            [
                'user_id' => $id
            ],
        );

        $dataProviderTransaction = $searchModelTranscation->search($this->request->queryParams);

        $searchModelBonus = new BonusSearch(
            [
                'user_id' => $id
            ],
        );

        $dataProviderBonus = $searchModelBonus->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModelTransaction' => $searchModelTranscation,
            'dataProviderTransaction' => $dataProviderTransaction,
            'searchModelBonus' => $searchModelBonus,
            'dataProviderBonus' => $dataProviderBonus,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Create augment transaction.
     * @param int $user_id ID
     * @return string|\yii\web\Response
     */
    public function actionAugmentTransaction($user_id)
    {
        $model = new CreateTransactionAugment(['user' => $this->findModel($user_id)]);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['user/view', 'id' => $user_id]);
        }

        return $this->render('transaction', [
            'model' => $model,
        ]);
    }

    /**
     * Create deduct transaction.
     * @param int $user_id ID
     * @return string|\yii\web\Response
     */
    public function actionDeductTransaction($user_id)
    {
        $model = new CreateTransactionDeduct(['user' => $this->findModel($user_id)]);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['user/view', 'id' => $user_id]);
        }

        return $this->render('transaction', [
            'model' => $model,
        ]);
    }
}
