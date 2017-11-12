<?php

use yii\db\Migration;

/**
 * Handles the creation of table `newmenu`.
 */
class m171110_034837_create_newmenu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('newmenu', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer(12)->comment('��id'),
            'name' => $this->text(111)->comment('�˵�����'),
            'class' => $this->text(111)->comment('�ϼ��˵�'),
            'item' => $this->text(111)->comment('��ַ/·��'),
            'sort' => $this->text(111)->comment('����'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('newmenu');
    }
}
