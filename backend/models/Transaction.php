<?php

namespace backend\models;



use yii\db\ActiveRecord;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $value
 * @property string $purpose
 * @property string|null $created_at
 *
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
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
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'value', 'created_at'], 'integer'],
            [['purpose', 'value'], 'required'],
            [['value'], 'number'],

            [['purpose'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'value' => 'Сумма',
            'purpose' => 'Назначение',
            'created_at' => 'Время создания',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
