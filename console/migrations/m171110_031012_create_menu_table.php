<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m171110_031012_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->comment('�˵�����'),
            'class' => $this->text()->comment('�ϼ��˵�'),
            'item' => $this->text()->comment('��ַ/·��'),
            'sort' => $this->text()->comment('����'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
