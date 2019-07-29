<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%nfiles}}`.
 */
class m190726_065007_create_nfiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%nfiles}}', [
            'id' => $this->primaryKey(),
            'file_name'=> $this->string(50)->unique(),
            'upload_name'=> $this->string(100),
            'order_id'=>$this->integer()->notNull(),
            'user_id'=>$this->integer()->notNull(),
        ]);
         $this->createIndex(
            'idx-nfiles-order_id',
            'nfiles',
            'order_id'
        );
         $this->addForeignKey(
            'fk-nfiles-order_id',
            'nfiles',
            'order_id',
            'notary',
            'id'
        );
         $this->createIndex(
            'idx-nfiles-user_id',
            'nfiles',
            'user_id'
        );
          $this->addForeignKey(
            'fk-nfiles-user_id',
            'nfiles',
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
          'fk-nfiles-order_id',
            'nfiles'
        );
          $this->dropIndex(
            'idx-nfiles-order_id',
            'nfiles'
        );
         $this->dropForeignKey(
          'fk-nfiles-user_id',
            'nfiles'
        );
          $this->dropIndex(
            'idx-nfiles-user_id',
            'nfiles'
        );
        $this->dropTable('{{%nfiles}}');
    }
}
