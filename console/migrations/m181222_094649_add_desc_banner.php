<?php

use yii\db\Migration;

/**
 * Class m181222_094649_add_desc_banner
 */
class m181222_094649_add_desc_banner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('banner','description',$this->string(500));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181222_094649_add_desc_banner cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181222_094649_add_desc_banner cannot be reverted.\n";

        return false;
    }
    */
}
