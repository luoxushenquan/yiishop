<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/13
 * Time: 16:24
 */
namespace frontend\models;
use yii\db\ActiveRecord;

class Address extends ActiveRecord{


    public function rules()
    {
        return [
            [['username', 'cmbprovince', 'cmbcity', 'cmbarea', 'content', 'tel'], 'required'],
            ['checkbox','safe']
        ];
    }
    public function attributeLabels(){
    return[

    ];
}
}