<?php

namespace common\models;


use backend\models\Bonus;
use backend\models\Transaction;
use Yii;
use yii\base\Model;

class CreateTransactionDeduct extends Model
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
     * Creates transaction and bonus
     *
     * @param array Request
     *
     * @return bool
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
            $model->purpose = $this->purpose;

            if (abs($this->value) >= $user->bonus) {
                $amount_transaction = abs($this->value) - $user->bonus;
                $model->value = $amount_transaction * -1;
            } else {
                $amount_transaction = 0;
                $model->value = $amount_transaction;
            }

            if ($user->balance - $amount_transaction >= 0) {

                if ($model->save()) {

                    if (abs($this->value) - $amount_transaction > 0) {
                        $bonus = new Bonus();
                        $bonus->user_id = $user->id;
                        $bonus->transaction_id = $model->id;

                        if ($amount_transaction !== 0) {
                            $bonus->value = (abs($this->value) - $amount_transaction) * -1;
                        } else {
                            $bonus->value = abs($this->value) * -1;
                        }

                        if ($bonus->save()) {
                            $t->commit();
                            return true;
                        } else {
                            throw new \Exception('Не удалось сохранить бонусную операцию ' . json_encode($user->errors));
                        }
                    } else {
                        $t->commit();
                        return true;
                    }
                } else {
                    Yii::$app->session->setFlash('error', "Сумма меньше нуля!");
                }
            } else {
                Yii::$app->session->setFlash('error', "Баланс будет меньше 0!");
            }

        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
        return false;
    }
}