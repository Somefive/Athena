<?php

use yii\db\Migration;

/**
 * Handles the creation of table `course_participants`.
 * Has foreign keys to the tables:
 *
 * - `course`
 * - `profile`
 */
class m160926_113027_create_course_participants_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('course_participants', [
            'id' => $this->primaryKey(),
            'course_id' => $this->integer(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
        ]);

        // creates index for column `course_id`
        $this->createIndex(
            'idx-course_participants-course_id',
            'course_participants',
            'course_id'
        );

        // add foreign key for table `course`
        $this->addForeignKey(
            'fk-course_participants-course_id',
            'course_participants',
            'course_id',
            'course',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-course_participants-user_id',
            'course_participants',
            'user_id'
        );

        // add foreign key for table `profile`
        $this->addForeignKey(
            'fk-course_participants-user_id',
            'course_participants',
            'user_id',
            'profile',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `course`
        $this->dropForeignKey(
            'fk-course_participants-course_id',
            'course_participants'
        );

        // drops index for column `course_id`
        $this->dropIndex(
            'idx-course_participants-course_id',
            'course_participants'
        );

        // drops foreign key for table `profile`
        $this->dropForeignKey(
            'fk-course_participants-user_id',
            'course_participants'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-course_participants-user_id',
            'course_participants'
        );

        $this->dropTable('course_participants');
    }
}
