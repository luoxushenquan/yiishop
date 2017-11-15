<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/15
 * Time: 15:47
 * 购物车控制器
 */
namespace frontend\controllers;
use frontend\models\Cart;
use yii\web\Controller;

class CartController extends Controller{
       public function actionAdd(){
           //添加商品到购物车
       }
    public function actionIndex(){
        $model = new Cart();
        $model->find()->all();
        return $this->render('index',['model'=>$model]);
    }
}