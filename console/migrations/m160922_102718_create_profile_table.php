<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m160922_102718_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'school_id' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'nickname' => $this->string(),
            'gender' => $this->string()->notNull()->defaultValue("male"),
            'department' => $this->string(),
            'class' => $this->string(),
            'contact' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('profile');
    }
}
