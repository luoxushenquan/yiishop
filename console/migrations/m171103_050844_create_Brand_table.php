<?php

use yii\db\Migration;

/**
 * Handles the creation of table `Brand`.
 */
class m171103_050844_create_Brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('Ãû³Æ'),
            'intro'=>$this->text()->notNull()->comment('¼ò½é'),
            'logo'=>$this->string(255)->notNull()->comment('LoGoÍ¼Æ¬'),
            'sort'=>$this->integer(11)->notNull()->comment('ÅÅÐò'),
            'status'=>$this->integer(2)->notNull()->comment('-1É¾³ý 0Òþ²Ø 1Õý³£')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Brand');
    }
}
