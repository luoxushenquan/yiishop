<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article-category`.
 */
class m171103_061145_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     * �ֶ���	����	ע��
    id	primaryKey
    name	varchar(50)	����
    intro	text	���
    sort	int(11)	����
    status	int(2)	״̬(-1ɾ�� 0���� 1����)
     */
    public function up()
    {
        $this->createTable('article-category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('����'),
            'intro'=>$this->text(255)->notNull()->comment('���'),
            'sort'=>$this->integer(11)->notNull()->comment('����'),
            'status'=>$this->integer(11)->notNull()->comment('״̬'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article-category');
    }
}
