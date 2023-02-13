<?php

namespace frontend\models;

use common\models\CreateTransactionDeduct;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $xlsxFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['xlsxFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    /**
     * Load file.
     *
     * @param string $filename modified filename
     * @return bool whether the email was sent
     */
    public function upload($filename)
    {
        if ($this->validate()) {
            $this->xlsxFile->saveAs($filename);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Load and Read File.
     *
     * @param string $user User
     * @return bool whether the email was sent
     */
    public function loadToRead()
    {
        $this->xlsxFile = UploadedFile::getInstance($this, 'xlsxFile');
        $file_name = Yii::$app->user->getId() . '_' . time() . '.' . $this->xlsxFile->extension;
        if ($this->upload($file_name)) {

            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($file_name);
            $reader->setReadDataOnly(true);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $model = new CreateTransactionDeduct(['user' => Yii::$app->user]);

            $transaction['CreateTransactionDeduct']['value'] = $data[1][1];
            $transaction['CreateTransactionDeduct']['purpose'] = $data[1][2];

            if ($model->load($transaction) && $model->create()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}