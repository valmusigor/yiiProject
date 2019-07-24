<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m190714_063517_create_notary_table extends Migration
{
     const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notary}}', [
            'id' => $this->primaryKey(),
            'document_name'=> $this->string(40),
            'country'=> $this->string(30), 
            'file_name'=> $this->string(50)->unique(),
            'upload_name'=> $this->string(100),
            'time_create_request'=> $this->integer(),
            'client_id'=> $this->integer(),
            'notary_id'=> $this->integer(),
            'status'=> $this->smallInteger(),
        ],self::FORMAT);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notary}}');
    }
}
