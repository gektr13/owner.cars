<?php

use yii\db\Migration;

/**
 * Class m230210_071213_add_is_admin_column_in_user_table
 */
class m230210_071213_add_is_admin_column_in_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('user', 'is_admin', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('user', 'is_admin');
    }
}
