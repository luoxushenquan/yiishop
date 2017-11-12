<?php

use yii\db\Migration;

/**
 * Handles the creation of table `nmenu`.
 */
class m171110_034557_create_nmenu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('nmenu', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->comment('��id'),
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
        $this->dropTable('nmenu');
    }
}
