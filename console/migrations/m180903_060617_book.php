<?php

use yii\db\Migration;

/**
 * Class m180903_060617_book
 */
class m180903_060617_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string('50')->notNull(),
            'surname' => $this->string('50')->notNull(),
            'email' => $this->string('50')->notNull(),
            'note' => $this->string('250')->notNull(),
            'admin_note' => $this->string('250')->notNull(),
            'date_start'=>$this->date(),
            'birthday'=>$this->date(),
            'price'=>$this->integer(),
            'currency' => $this->string('3'),
            'tour_id'=>$this->integer(),
            'price_id'=>$this->integer(),
            'group_of'=>$this->smallInteger(5),
            'payment_method'=>$this->smallInteger(5),
            'status'=>$this->smallInteger(5),
        ],$tableOptions);

        $this->createIndex('idx_book_tour', 'book', 'tour_id');
        $this->createIndex('idx_book_price', 'book', 'price_id');

        $this->addForeignKey(
            'fk-book-price_id','book','price_id','price','id',
            'RESTRICT','NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('book');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_060617_book cannot be reverted.\n";

        return false;
    }
    */
}
