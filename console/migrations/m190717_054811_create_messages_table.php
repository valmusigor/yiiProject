<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m190717_054811_create_messages_table extends Migration
{
     const FORMAT = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'text_message'=> $this->string(100),
            'time_create'=> $this->integer(),
            'sender_id'=> $this->integer(),
            'notary_request_id'=> $this->integer(),
            'status'=> $this->smallInteger(),
        ],self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
