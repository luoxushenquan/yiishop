<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/4
 * Time: 10:59
 */
namespace backend\models;
use yii\db\ActiveRecord;



class Article extends ActiveRecord{

    public function getArticleCategory(){
      return   $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }


    public function rules(){
        return[
            [['name','intro','article_category_id','sort','status'],'required'],

        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'文章名',
            'intro'=>'简介',
            'article_category_id'=>'文章分类',
            'sort'=>'排序',
            'status'=>'状态',
        ];
    }
}