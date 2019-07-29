<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forms_notarys}}`.
 */
class m190726_060452_create_forms_notarys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%forms_notarys}}', [
            'id' => $this->primaryKey(),
            'forms_id' => $this->integer()->notNull(),
            'notary_id' => $this->integer()->notNull(),
            'result_string'=>$this->string(255),
            
        ]);
        $this->createIndex(
            'idx-forms_notarys-forms_id',
            'forms_notarys',
            'forms_id'
        );
         $this->addForeignKey(
            'fk-forms_notarys-forms_id',
            'forms_notarys',
            'forms_id',
            'forms',
            'id'
        );
         $this->createIndex(
            'idx-forms_notarys-notary_id',
            'forms_notarys',
            'notary_id'
        );
          $this->addForeignKey(
            'fk-forms_notarys-notary_id',
            'forms_notarys',
            'notary_id',
            'notary',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropForeignKey(
          'fk-forms_notarys-forms_id',
          'forms_notarys'
        );
          $this->dropIndex(
            'idx-forms_notarys-forms_id',
            'forms_notarys'
        );
         $this->dropForeignKey(
          'fk-forms_notarys-notary_id',
            'forms_notarys'
        );
          $this->dropIndex(
            'idx-forms_notarys-notary_id',
            'forms_notarys'
        );
          
        $this->dropTable('{{%forms_notarys}}');
    }
}
