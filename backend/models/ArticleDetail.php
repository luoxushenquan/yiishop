<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/4
 * Time: 11:09
 */
namespace backend\models;
use yii\db\ActiveRecord;

class ArticleDetail extends ActiveRecord{
    public function rules(){
        return[
            ['content','required'],

        ];
    }
    public function attributeLabels(){
        return[
            'content'=>'文章内容',
        ];
    }
}