<?php

use yii\db\Migration;

/**
 * Class m180830_124956_category_desc
 */
class m180830_124956_category_desc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('category_desc', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull(),
            'image' => $this->string('50')->notNull(),
            'intro' => $this->string('500')->notNull(),
            'description' => $this->text()->notNull(),
            'category_id'=>$this->integer(),
            'destination_id'=>$this->integer(),
        ],$tableOptions);

        $this->createIndex('idx_ctgdesc_ctg', 'category_desc', 'category_id');
        $this->createIndex('idx_ctgdesc_dest', 'category_desc', 'destination_id');

        $this->addForeignKey(
            'fk-ctgdesc-ctg','category_desc','category_id','category','id',
            'RESTRICT','NO ACTION'
        );
        $this->addForeignKey(
            'fk-ctgdesc-desc','category_desc','destination_id','destination','id',
            'RESTRICT','NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category_desc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_124956_category_desc cannot be reverted.\n";

        return false;
    }
    */
}
