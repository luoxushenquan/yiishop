<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article-category`.
 */
class m171103_061145_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     * ×Ö¶ÎÃû	ÀàÐÍ	×¢ÊÍ
    id	primaryKey
    name	varchar(50)	Ãû³Æ
    intro	text	¼ò½é
    sort	int(11)	ÅÅÐò
    status	int(2)	×´Ì¬(-1É¾³ý 0Òþ²Ø 1Õý³£)
     */
    public function up()
    {
        $this->createTable('article-category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('Ãû³Æ'),
            'intro'=>$this->text(255)->notNull()->comment('¼ò½é'),
            'sort'=>$this->integer(11)->notNull()->comment('ÅÅÐò'),
            'status'=>$this->integer(11)->notNull()->comment('×´Ì¬'),
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
