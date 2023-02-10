<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction}}`.
 */
class m230210_080119_create_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction}}', [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer(),
            'value' => $this->float(),
            'purpose' => $this->string()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-transaction-user_id',
            'transaction',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }
}
