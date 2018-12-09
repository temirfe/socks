<?php

use yii\db\Migration;

/**
 * Class m181209_080911_category_add
 */
class m181209_080911_category_add extends Migration
{
    public $tableName='category';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn($this->tableName,'parent_id','integer(11)');
        $this->addColumn($this->tableName,'description',$this->string(500));
        $this->addColumn($this->tableName,'image',$this->string(200));
        $this->addColumn($this->tableName,'public',$this->boolean());
        $this->addColumn($this->tableName,'weight',$this->integer(2)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181209_080911_category_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181209_080911_category_add cannot be reverted.\n";

        return false;
    }
    */
}
