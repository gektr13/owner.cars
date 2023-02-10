<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bonus}}`.
 */
class m230210_080652_create_bonus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bonus}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'transaction_id' =>  $this->integer(),
            'value' => $this->float(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-bonus-user_id',
            'bonus',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-bonus-transaction_id',
            'bonus',
            'transaction_id',
            'transaction',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bonus}}');
    }
}
