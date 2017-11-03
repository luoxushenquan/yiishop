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
            'name'=>$this->string(50)->notNull()->comment('����'),
            'intro'=>$this->text()->notNull()->comment('���'),
            'logo'=>$this->string(255)->notNull()->comment('LoGoͼƬ'),
            'sort'=>$this->integer(11)->notNull()->comment('����'),
            'status'=>$this->integer(2)->notNull()->comment('-1ɾ�� 0���� 1����')
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
