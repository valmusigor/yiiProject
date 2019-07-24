<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token'=>$this->string(255)->defaultValue(NULL),
            'role'=>$this->tinyInteger()->notNull(),
        ], $tableOptions);
        $this->createAdmin();
    }
    public function createAdmin(){
        $this->insert('{{%user}}', [
        'username'=>'admin', 
        'auth_key'=>'9ezp1AObvatbt1A7sVCi-boDfWc-UYuz',
        'password_hash'=>'$2y$13$n7CK1lRH1RlC4IS/ZWnOi.sdgE3aFrygDoRBSP8giS4//.BP9MyAm',
        'password_reset_token'=>NULL,
        'email' => 'admin@mail.ru',
        'status'=>'10', 
        'created_at' =>'1563776235',
        'updated_at'=> '1563776235',
        'verification_token'=>NULL, 
         'role'=>3,
]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
