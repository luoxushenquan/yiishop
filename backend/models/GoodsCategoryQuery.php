<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/5
 * Time: 21:27
 */

namespace backend\models;
use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;
class GoodsCategoryQuery extends ActiveQuery{
    public function behaviors(){
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}