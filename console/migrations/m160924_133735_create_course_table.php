<?php

use yii\db\Migration;

/**
 * Handles the creation of table `course`.
 */
class m160924_133735_create_course_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('course', [
            'id' => $this->primaryKey(),
            'teacher_id' => $this->integer(),
            'name' => $this->string(),
            'abstract' => $this->text(),
            'start_at' => $this->date(),
            'status' => $this->string()->defaultValue("pending")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('course');
    }
}
