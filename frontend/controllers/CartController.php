<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/15
 * Time: 15:47
 * 购物车控制器
 */
namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Cart;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Request;
use Yii;

class CartController extends Controller
{
    public $enableCsrfValidation = false;

//购物车列表
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            $cookie = \Yii::$app->request->cookies;
            $carts = $cookie->getValue('carts');
//            var_dump($carts);exit;
            if ($carts) {
                $carts = unserialize($carts);//反序列化
            } else {
                $carts = [];
            }

            //获取商品信息
            $models = Goods::find()->where(['in', 'id', array_keys($carts)])->all();
//            var_dump($models);exit;

            return $this->render('index', ['carts' => $carts, 'models' => $models]);
        } else {
//            exit;///////////////////////////////////////////////
//            $model = new Cart();
//            $model->find()->all();
//            $models=Goods::find()->all();
            $user_id = \Yii::$app->user->id;
            $models = Cart::find()->joinWith('goods')->where(['member_id' => $user_id])->all();
//            print_r($models);exit;
            return $this->render('index1', ['models' => $models]);
        }

    }

    //删除购物车
    public function actionDelete($id)
    {
//        var_dump($id);exit;
        if (\Yii::$app->user->isGuest) {
            //没登录执行
            $cookie = \Yii::$app->request->cookies;
            $carts = $cookie->getValue('carts');
//            $carts=unserialize($carts);//反序列化


            \Yii::$app->response->cookies->remove('carts');

        } else {
//            登陆执行；
//            exit;
            $model = Cart::findOne(['id' => $id]);
//             var_dump($model);  exit;
            $model->delete();
        }

        return $this->redirect(['index']);
    }

//添加商品到购物车
    public function actionAdd($goods_id, $amount)
    {
        if (\Yii::$app->user->isGuest) {
            //操作cookied 购物车
            //获取cookiezhong shuju
            $cookie = \Yii::$app->request->cookies;

            $carts = $cookie->getValue('carts');
            if ($carts) {
                $carts = unserialize($carts);//反序列化
            } else {
                $carts = [];
            }
            //购物车中是否有该商品
            if (array_key_exists($goods_id, $carts)) {
                $carts[$goods_id] += $amount;
            } else {
                $carts[$goods_id] = $amount;
            }

//            $carts=[$goods_id=>$amount];
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie();
            $cookie->name = 'carts';
            $cookie->value = serialize($carts);
            $cookies->add($cookie);
        } else {

            //操作数据哭的 购物车
//            var_dump($goods_id,$amount);exit;
            $model = new Cart();
            $model->load(\Yii::$app->request->get(), '');
            if ($model->validate()) {
                $member_id = \Yii::$app->user->id;
//                var_dump($member_id,$goods_id);die;
                $result = $model->findOne(["member_id" => $member_id, "goods_id" => $goods_id]);
                if ($result) {
                    $result->amount = $result->amount + $amount;
                    $result->save();
                } else {
                    $model->member_id = $member_id;
                    $model->goods_id =$goods_id ;
                    $model->save();
                }
//                $model->goods_id=$goods_id;
//                $model->amount=$amount;a
//
////                var_dump($member_id);exit;

////                exit;
//                $model->save();
////                echo '11';exit;
            } else {
                var_dump($model->getErrors());
                exit;
            }


        }
        return $this->redirect(['cart/index']);
    }

    //ajax操作购物车
    public function actionAjaxCart($type)
    {
        //登陆操作数据库未登录操作cookie
        switch ($type) {
            case 'change'://修改购物车
                $goods_id = \Yii::$app->request->post('goods_id');
                $amount = \Yii::$app->request->post('amount');
                if (\Yii::$app->user->isGuest) {
                    $cookie = \Yii::$app->request->cookies;
                    $carts = $cookie->getValue('carts');
                    if ($carts) {
                        $carts = unserialize($carts);//反序列化
                    } else {
                        $carts = [];
                    }
                    $carts[$goods_id] = $amount;
                    //保存cookie
                    $cookies = \Yii::$app->response->cookies;
                    $cookie = new Cookie();
                    $cookie->name = 'carts';
                    $cookie->value = serialize($carts);
                    $cookies->add($cookie);

                } else {


                }

                break;
            case 'del':
                break;
        }
    }
}