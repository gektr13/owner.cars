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
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
     */
    public function actionIndex()
    {
        $file = new UploadForm();

        if (Yii::$app->request->isPost) {
            $file->imageFile = UploadedFile::getInstance($file, 'imageFile');
            if ($file->upload()) {

                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($file->imageFile->name);

                $reader->setReadDataOnly(true);


                $sheetsCount = $spreadsheet->getSheetCount();

                $data = $spreadsheet->getActiveSheet()->toArray();

                foreach ($data as $item):
                    var_dump($item);
                endforeach;
                exit();
            }
        }

        return $this->render('index', [
            'model' => $this->findModel(Yii::$app->user->id),
            'file' => $file,
        ]);
    }

    /**
     * User Transactions.
     *
     * @return string
     */
    public function actionTransaction()
    {
        $model = $this->findModel(Yii::$app->user->id);

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
     * User Transactions.
     *
     * @return string
     */
    public function actionBonus()
    {
        $model = $this->findModel(Yii::$app->user->id);

        $searchModel = new BonusSearch(
            [
                'user_id' => $model->id,
            ],
        );

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
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionDeductTransaction($user_id)
    {

        $model = new CreateTransactionDeduct(['user' => $this->findModel($user_id)]);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['user/transaction']);
        }

        return $this->render('deduct', [
            'model' => $model,
        ]);
    }
}
