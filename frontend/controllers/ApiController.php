<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/23
 * Time: 10:41
 */
namespace frontend\controllers;
use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\models\Member;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use frontend\models\Address;
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function init()
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    public function actionLogin()
    {
        $result = [
            'error' => null,
            'msg' => '',
            'data' => []
        ];
        $username = \Yii::$app->request->post('username');

        $password = \Yii::$app->request->post('password_hash');
        $admin = Member::findOne(['username' => $username]);
//        var_dump($admin);exit;
        if ($admin) {
            if (\Yii::$app->security->validatePassword($password, $admin->password_hash)) {
                //验证成功
                \Yii::$app->user->login($admin);
                $result['msg'] = '登陆成功';
                $result['data'] = $admin;

            } else {
                //密码错误
                $result['msg'] = '密码错误';
                $result['error'] = 1;
            }

        } else {
            $result['msg'] = '账号不存在';
        }
        return $result;
    }

    public function actionRegister()
    {
        //注册接口

        $result = [
            'msg' => ''
        ];
        $model = new Member();
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');
        $emali = \Yii::$app->request->post('emali');
        $tel = \Yii::$app->request->post('tel');
        $model->created_at = time();
        //自动登录用的创建用户时需要设置auth_key  修改密码重新生成(更安全
        $model->auth_key = time() . '2233';//随机字符串
        $model->password_hash = \yii::$app->security->generatePasswordHash($password);
        $model->username = $username;
        $model->emali = $emali;
        $model->username = $tel;
        if ($model->save()) {
            $result['msg'] = '注册成功';
        } else {
            $result['msg'] = '注册失败';
        }
    }

    public function actionUser()
    {
        //获取当前登陆用户的信息
        $id = \Yii::$app->user->id;
        $member = new Member();
        $member = $member->findOne(['id' => $id]);
        return $member;
    }

    public function actionAddress()
    {
        $model = new Address();
        $request = New Request();
        $result = [
            'error' => null,
            'msg' => '',
            'data' => []
        ];
        //-添加地址
        if ($request->isPost) {
            $model->load($request->post(), '');
            if ($model->validate()) {
                //获取登录信息
                $name = \Yii::$app->user->id;
//                var_dump($name);exit;
                $model->name = $name;
                $model->save(0);
//                echo '添加成功';exit;
                $this->redirect(['add']);
                $result['msg']='地址添加成功';
            } else {
                $result['error']='1';
            }

        }
        return $result;
    }
    public function actionDelress($id){
        //-删除地址
        $result = [
            'error' => null,
            'msg' => '',
            'data' => []
        ];
//        \Yii::$app->request->get('id');
        $ress=new Address();
        $v =$ress->findOne(['id'=>$id]);
//        var_dump($v);exit;
        if($v->delete()){
            return $result['msg']='删除成功';
        }else{
            return $result['msg']='删除失败';
        };

     }
    public function actionGoodsCrate(){
        //-获取所有商品分类
        $goodsCategory=GoodsCategory::find();
        $result = [
            'error' => null,
            'msg' => '',
            'data' => []
        ];
        $goodsCategory = $goodsCategory->orderBy('tree ASC,lft ASC')->all();
        if($goodsCategory){
//            return $goodsCategory;
            $result['data']=$goodsCategory;
        }else{
             $result['msg']='没有数据';
        }
        return $result;
    }
    public function actionSub($goods_category_id){
        $result = [
            'error' => null,
            'msg' => '',
            'data' => []
        ];
        //获取子分类  id
        $goods_category = GoodsCategory::findOne(['id'=>$goods_category_id]);
//        var_dump($goods_category);exit;
        //三级分类

        if($goods_category->depth == 2){
//            exit;
            $query = Goods::find()->where(['goods_category_id'=>$goods_category_id]);

        }else{
            ;
            $ids = $goods_category->children()->andWhere(['depth'=>2])->column();
//            var_dump($ids);exit;
            $query = Goods::find()->where(['in','goods_category_id',$ids]);
//            var_dump($query);exit;
            if($query){
                $result['data']=$query;
            }else{
                $result['msg']='该分类没有子分类';
            }

        }
        return $result;
    }
    public function actionParent($parent_id){
        //获取副分类

    }
}