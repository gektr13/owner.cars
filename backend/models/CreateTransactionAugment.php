<?php

namespace backend\models;


use yii\base\Model;

class CreateTransactionAugment extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var float
     */
    public $value;
    /**
     * @var string
     */
    public $purpose;

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            [['value'], 'number', 'min' => 1],
            [['purpose'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function create()
    {
        $t = \Yii::$app->db->beginTransaction();
        try {
            $user = $this->user;

            if (!($user instanceof User)) {
                throw new \Exception('Необходимо указать пользователя');
            }

            if (!$this->validate()) {
                return false;
            }

            $model = new Transaction();
            $model->user_id = $this->user->id;
            $model->value = abs($this->value);
            $model->purpose = $this->purpose;

            if ($model->save()) {

                $bonus = new Bonus();
                $bonus->user_id = $user->id;
                $bonus->transaction_id = $model->id;
                $bonus->value = $model->value * 0.1;

                if($bonus->save()){
                    $t->commit();

                    return true;
                }else{
                    throw new \Exception('Не удалось сохранить бонусы' . json_encode($model->errors));
                }
            } else {
                throw new \Exception('Не удалось сохранить транзакцию ' . json_encode($model->errors));
            }
        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
    }

}