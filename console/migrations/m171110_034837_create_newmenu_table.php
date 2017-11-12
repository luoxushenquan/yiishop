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
            'pid' => $this->integer(12)->comment('父id'),
            'name' => $this->text(111)->comment('菜单名称'),
            'class' => $this->text(111)->comment('上级菜单'),
            'item' => $this->text(111)->comment('地址/路由'),
            'sort' => $this->text(111)->comment('排序'),
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
