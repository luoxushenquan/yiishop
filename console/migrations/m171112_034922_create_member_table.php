<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m171112_034922_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->unique()->comment('用户名'),
            'auth_key' => $this->string(32)->notNull()->comment(''),
            'password_hash' => $this->string()->notNull()->comment('密码(密文)'),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),
            'tel' => $this->char(11)->notNull()->unique()->comment('电话号码'),
            'last_login_time' => $this->integer()->notNull()->comment('最后登陆时间'),
            'last_login_ip' => $this->integer()->notNull()->comment('最后登录ip'),
            'status' => $this->smallInteger()->notNull()->comment('状态(1正常,0删除)'),
            'created_at' => $this->integer()->notNull()->comment('添加时间'),
            'updated_at' => $this->integer()->notNull()->comment('修改时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
