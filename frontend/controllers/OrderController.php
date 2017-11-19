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
       //û�е�¼��ת��¼ҳ��
       if(\Yii::$app->user->isGuest){
           return $this->redirect(['member/login']);
       }

       $request=new Request();
       if($request->isPost){

           $order=new Order();
           $order->member_id=\Yii::$app->user->id;
           $address_id=$request->post('address_id');
//           var_dump($address_id);exit;
           $address=Address::findOne(['id'=>$address_id,'name'=>\Yii::$app->user->id]);
//           var_dump($address);exit;
           if($address==null){

           }

           //�û�id
           $order->member_id=$address->name;

           //�ջ���
           $order->name=$address->username;
           $order->province=$address->cmbprovince;
           $order->city=$address->cmbcity;
           $order->area=$address->cmbarea;
           $order->address=$address->content;
           $order->tel=$address->tel;

           $order->delivery_id=$request->post('delivery_id');
           $order->delivery_name=Order::$deliveries[$order->delivery_id][0];
           var_dump($order->delivery_name);exit;
           $order->delivery_price=Order::$deliveries[$order->delivery_id][1];

           //֧����ʽ id����
           $order->payment_name=Order::$zhifu[$order->delivery_id][0];
           //���
            $order->total=$order->delivery_price;
            $order->status=1;
            $order->trade_no=333;
            $order->create_time=time();
           //��������
           $transaction = \Yii::$app->db->beginTransaction();
           try{
               if( $order->save()){
                   //���涩����Ʒ��
                   $carts=Cart::find()->where(['member'=>\Yii::$app->user->id])->all();
                   foreach($carts as $cart){

                       //����湻��
                       if($cart->amount > $cart->goods->stock){
                           throw new Exception( $cart->goods->name.'��Ʒû����');

                       }

                       $order_goods=new OrderGoods();
                       $order_goods->order_id=$order->id;
                       $order_goods->goods_id=$cart->goods_id;
                       //Ҫ������ϵ
                       $order_goods->goods_name=$cart->goods->name;
                       $order_goods->logo=$cart->goods->logo;
                       $order_goods->price=$cart->goods->shop_price;
                       $order_goods->amount=$cart->amount;
                       $order_goods->total=$order_goods->price*$order_goods->amount;
                       $order_goods->save();
                       $order->total+= $order_goods->total;
                       //�ۼ���Ʒ���
                       Goods::updateAllCounters(['stock'=>-$cart->amount],['id'=>$cart->goods_id]);
                   }
                   //ɾ�����ﳵ
                   Cart::deleteAll('member_id='.\Yii::$app->user->id);
                   $order->save();

               }
               //�ύʳ��
               $transaction->commit();

           }catch(Exception $e){
               //�ع�
               $transaction->rollBack();
               //�µ�ʧ�� ��ʾ��治��
               echo $e->getMessage();exit;
           }
       }
       $member = \Yii::$app->user->id;
       //��ȡ�û��ջ���ַ
       $address = new Address();
//       var_dump($member);exit;
       $address=$address->find()->where(['name'=>$member])->all();
       $user_id = \Yii::$app->user->id;
       $goods = Cart::find()->joinWith('goods')->where(['member_id' => $user_id])->all();
//            print_r($goods);exit;
       return $this->render('add', ['address'=>$address,'goods' => $goods]);
   }
    public function actionIndex(){
        $model = OrderGoods::find()->all();
//        var_dump($model);exit;
            return $this->render('index',['model'=>$model]);
    }

}