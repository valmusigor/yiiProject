<?php

use yii\db\Migration;

/**
 * Handles adding todelete to table `{{%forms}}`.
 */
class m190728_081602_add_todelete_column_to_forms_table extends Migration
{
     public function up()
    {
        $this->addColumn('{{%forms}}', 'todelete', $this->integer()->defaultValue(2));
    }
    public function down()
    {
        $this->dropColumn('{{%forms}}', 'todelete');
    }
}
