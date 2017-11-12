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
        $this->dropTable('menu');
    }
}
