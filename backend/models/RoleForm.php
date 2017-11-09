<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/9
 * Time: 14:20
 */
namespace backend\models;
use yii\base\Model;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions;
    public function rules(){
        return[
          [['name','description','permissions'],'required'],
            ['permissions','safe']
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'角色',
            'description'=>'简介',
            'permissions'=>'权限',
        ];
    }

}