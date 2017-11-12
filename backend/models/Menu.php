<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/10
 * Time: 11:22
 */

namespace backend\models;
use yii\db\ActiveRecord;

class Menu extends ActiveRecord{
    public function rules(){
        return[
            [['name','class','item','sort'],'required'],
            [['name'],'unique'],
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'名称',
            'class'=>'上级菜单',
            'item'=>'地址/路由',
            'sort'=>'排序',
        ];
    }

    //一级菜单赫尔及菜单的关系
    public function getChildren(){
        //儿子 parent_id和父亲 id
        return $this->hasMany(self::className(),['class'=>'id']);
    }
}