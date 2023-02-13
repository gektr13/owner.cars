<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "bonus".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $transaction_id
 * @property int|null $value
 * @property string|null $created_at
 *
 * @property User $user
 */
class Bonus extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'created_at'], 'integer'],
            [['value'], 'required'],
            [['value'], 'number'],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::class, 'targetAttribute' => ['transaction_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'value' => 'Value',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranaction()
    {
        return $this->hasOne(Transaction::class, ['id' => 'transactions_id']);
    }

}
