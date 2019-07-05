<?php

use yii\db\Migration;

/**
 * Class m190703_120727_create_all_tables
 */
class m190703_120727_create_all_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'taskId' => $this->primaryKey(),
            'text'=> $this->string(255),
            'time_end'=> $this->integer()->unsigned(),
            'time_create'=> $this->integer()->unsigned(),
            'userId'=> $this->integer()->unsigned(),
        ]);
        $this->createTable('{{%users}}', [
            'userId' => $this->primaryKey(),
            'login'=> $this->string(20)->unique(),
            'pass'=> $this->string(50), 
            'email'=> $this->string(20)->unique(),
            'role'=> $this->string(20),
        ]);
        $this->createTable('{{%files}}', [
            'fileId' => $this->primaryKey(),
            'name'=> $this->string(50)->unique(),
            'downloadName'=> $this->string(10),
            'uploadName'=> $this->string(50),
            'userId'=> $this->integer()->unsigned(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('{{%task}}');
       $this->dropTable('{{%users}}');
       $this->dropTable('{{%files}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190703_120727_create_all_tables cannot be reverted.\n";

        return false;
    }
    */
}
