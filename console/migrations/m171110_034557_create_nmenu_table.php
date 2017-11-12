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
            'pid' => $this->integer()->comment('父id'),
            'name' => $this->text()->comment('菜单名称'),
            'class' => $this->text()->comment('上级菜单'),
            'item' => $this->text()->comment('地址/路由'),
            'sort' => $this->text()->comment('排序'),
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
