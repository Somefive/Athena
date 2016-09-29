<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m160928_115153_create_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'from' => $this->integer()->notNull(),
            'to' => $this->integer()->notNull(),
            'type' => $this->string(),
            'content' => $this->text(),
            'created_at' => $this->dateTime(),
            'viewed_at' => $this->dateTime()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('message');
    }
}
