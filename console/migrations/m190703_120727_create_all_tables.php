<?php

use yii\db\Migration;

/**
 * Class m190703_120727_create_all_tables
 */
class m190703_120727_create_all_tables extends Migration
{
    const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
       $this->createTask();
       $this->createUsers();
       $this->createFiles();
    }
    public function createTask(){
         $this->createTable('{{%task}}', [
            'taskId' => $this->primaryKey(),
            'text'=> $this->string(255),
            'time_end'=> $this->integer(),
            'time_create'=> $this->integer(),
            'userId'=> $this->integer(),
        ],self::FORMAT
                 );
    }
    public function createUsers(){
         $this->createTable('{{%users}}', [
            'userId' => $this->primaryKey(),
            'login'=> $this->string(20)->unique(),
            'pass'=> $this->string(50), 
            'email'=> $this->string(20)->unique(),
            'role'=> $this->string(20),
        ],self::FORMAT);
    }
    public function createFiles(){
        $this->createTable('{{%files}}', [
            'fileId' => $this->primaryKey(),
            'name'=> $this->string(50)->unique(),
            'downloadName'=> $this->string(10),
            'uploadName'=> $this->string(50),
            'userId'=> $this->integer(),
        ],self::FORMAT);
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
