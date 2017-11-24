<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/17
 * Time: 11:20
 */
namespace frontend\controllers;
use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class OrderController extends Controller{
    public $enableCsrfValidation=false;
   public function actionAdd(){
       //没有登录跳转登录页面
       if(\Yii::$app->user->isGuest){
           return $this->redirect(['member/login']);
       }

       $request=new Request();
       if($request->isPost){
           $order=new Order();
           $order->member_id=\Yii::$app->user->id;
           $address_id=$request->post('address_id');
           $address=Address::findOne(['id'=>$address_id,'name'=>\Yii::$app->user->id]);
           if($address==null){
           }
           //用户id
           $order->member_id=$address->name;
           //收货人
           $order->name=$address->username;
           $order->province=$address->cmbprovince;
           $order->city=$address->cmbcity;
           $order->area=$address->cmbarea;
           $order->address=$address->content;
           $order->tel=$address->tel;
           $order->delivery_id=$request->post('delivery');
           $order->delivery_name=Order::$deliveries[$order->delivery_id][0];
           $order->delivery_price=Order::$deliveries[$order->delivery_id][1];
           //支付方式 id不管
           $order->payment_name=Order::$zhifu[$order->delivery_id][0];
           //金额
            $order->total=$order->delivery_price;
            $order->status=1;
            $order->trade_no=333;
            $order->create_time=time();
           //开启事务
           $transaction = \Yii::$app->db->beginTransaction();
           try{
//               exit;
               if( $order->save()){
                   //保存订单商品表
                   $carts=Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
                   foreach($carts as $cart){

                       //检查库存够不
                       if($cart->amount > $cart->goods->stock){
                           throw new Exception( $cart->goods->name.'商品没得了');

                       }

                       $order_goods=new OrderGoods();
                       $order_goods->order_id=$order->id;
                       $order_goods->goods_id=$cart->goods_id;
                       //要建立关系
                       $order_goods->goods_name=$cart->goods->name;
                       $order_goods->logo=$cart->goods->logo;
                       $order_goods->price=$cart->goods->shop_price;
                       $order_goods->amount=$cart->amount;
                       $order_goods->total=$order_goods->price*$order_goods->amount;
                       $order_goods->save();
                       $order->total+= $order_goods->total;
                       //扣减商品库存
                       Goods::updateAllCounters(['stock'=>-$cart->amount],['id'=>$cart->goods_id]);

                   }
                   //删除购物车
                   Cart::deleteAll('member_id='.\Yii::$app->user->id);

                   $order->save();

               }
               //提交食物
               $transaction->commit();
            return $this->redirect('index');
           }catch(Exception $e){
               //回滚
//               exit;
               $transaction->rollBack();
               //下单失败 提示库存不足
               echo $e->getMessage();exit;
           }
       }
       $member = \Yii::$app->user->id;
       //获取用户收货地址
       $address = new Address();
//       var_dump($member);exit;
       $address=$address->find()->where(['name'=>$member])->all();
       $user_id = \Yii::$app->user->id;
       $goods = Cart::find()->joinWith('goods')->where(['member_id' => $user_id])->all();
//            print_r($goods);exit;
       return $this->render('add', ['address'=>$address,'goods' => $goods]);
   }
    public function actionIndex(){
        $user_id = \Yii::$app->user->id;
        $model = OrderGoods::find()->all();
//        var_dump($model);exit;
            return $this->render('index',['model'=>$model]);
    }
//        if(\Yii::$app->user->isGuest){
//            return $this->redirect(['member/login']);
//        }
//        $member_id=\Yii::$app->user->identity->id;
////得到地址数据
//        $address=Address::find()->where(['member_id'=>$member_id])->all();
////得到购物车商品
//        $carts=Cart::find()->where(['member_id'=>$member_id])->all();
//        $cart=ArrayHelper::map($carts,'goods_id','amount');
////得到商品具体信息
//        $goods=Goods::find()->where(['in','id',array_keys($cart)])->all();
//        return $this->render('index',['address'=>$address,'carts'=>$cart,'goods'=>$goods]);


    }
