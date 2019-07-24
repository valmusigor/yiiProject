<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forms}}`.
 */
class m190720_043233_create_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%forms}}', [
            'id' => $this->primaryKey(),
            'form_name'=> $this->string(100)->notNull(),
            'field_name'=> $this->string(100)->notNull(),
            'type_field'=> $this->string(100)->notNull(),
            'required'=>$this->tinyInteger(),
            'uniquie'=>$this->tinyInteger(),
            'type_value'=> $this->string(100)->notNull(),
            'size'=> $this->integer(),
            'for_table'=>$this->string(100)->notNull(),
            'extensions'=>$this->string(45),
            'file_size'=>$this->integer(),
        ]);
        $this->insertData();
    }
    public function insertData() {
        $this->batchInsert('{{%forms}}', [
            'form_name',
            'field_name',
            'type_field',
            'required',
            'uniquie',
            'type_value',
            'size',
            'for_table',
            'extensions',
            'file_size'   
            ], [['requestaddform','document_name','textInput',1,2,'string',40,'notary',NULL,NULL],
                ['requestaddform','country','textInput',1,2,'string',30,'notary',NULL,NULL],
                ['requestaddform','file_name','fileInput',1,2,'string',100,'notary','pdf',3000000],
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%forms}}');
    }
}
