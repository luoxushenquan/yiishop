<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/17
 * Time: 11:21
 */
namespace frontend\models;
use yii\db\ActiveRecord;

class Order extends ActiveRecord{

    public static $deliveries=[
        1=>['东风快递',999999999,'速度快不晚点，全球投递'],
        2=>['战神旋风快递',888888,'速度快不晚点，国内送达'],
        3=>['战神快递',1999,'速度快不晚点，同城送达'],
    ];
    public static $zhifu=[
        1=>['在线支付','方便你我他全球零距离'],
        2=>['霸王餐','你是发哥可以用'],
        3=>['空头支票','城市套路深'],
    ];

}