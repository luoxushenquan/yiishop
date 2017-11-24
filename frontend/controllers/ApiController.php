<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/23
 * Time: 10:41
 */
namespace frontend\controllers;
use backend\models\Article;
use backend\models\ArticleCategory;
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
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $html = $redis->get('goods-category');

        if($html == false){

            $html =  '<div class="cat_bd">';
            //遍历一级分类
            $categories = self::find()->where(['parent_id'=>0])->all();
            foreach ($categories as $k1=>$category){
                $html .= '<div class="cat '.($k1==0?'item1':'').'">
                    <h3><a href="'.\yii\helpers\Url::to(['goods/list']).'">'.$category->name.'</a><b></b></h3>
                    <div class="cat_detail">';
                //耳机
                $categories2 = $category->children(1)->all();
                foreach ($categories2 as $k2=>$category2){
                    $html .= '<dl '.($k2==0?'class="dl_1st"':'').'>
                            <dt><a href="'.\yii\helpers\Url::to(['goods/list','goods_category_id'=>$category2->id]).'">'.$category2->name.'</a></dt>
                            <dd>';
                    //三级
                    $categories3 = $category2->children(1)->all();
                    foreach ($categories3 as $category3){
                        $html .= '<a href="'.\yii\helpers\Url::to(['goods/list','goods_category_id'=>$category3->id]).'">'.$category3->name.'</a>';
                    }
                    $html .= '</dd>
                        </dl>';
                }
                $html .= '</div>
                </div>';
            }
            $html .= '</div>';
            //保存到redis
            $redis->set('goods-category',$html,24*3600);
        }
        return $html;

//        return $result;
    }

    public function actionCate($goods_category_id){
        //-获取某分类下面的所有商品（不考虑分页）
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
    //4.商品


//-获取某品牌下面的所有商品（不考虑分页）
public function actionBrandgoods($brand_id){
    $result = [
        'error' => null,
        'msg' => '',
        'data' => []
    ];
    $goods=new Goods();
    $goods=$goods->find()->where(['brand_id'=>$brand_id])->all();
    if($goods){
        $result['data']=$goods;
    }else{
        $result['msg']='没有商品';
    }
    return $result;
}
//5.文章
//-获取文章分类
public function actionArticlec(){
    $result = [
        'error' => null,
        'msg' => '',
        'data' => []
    ];
    $articlec=new ArticleCategory();
    $articlec = $articlec->find()->all();
    if($articlec){
        $result['data']=$articlec;
    }else{
        $result['msg']='没有类';
    }
    return $result;
}
//-获取某分类下面的所有文章
public function actionCategoryarticle($articlecategory_id){
    //$articlecategory_id文章分类id
    $result = [
        'error' => null,
        'msg' => '',
        'data' => []
    ];
    $article=new Article();
    $article=$article->find()->where(['article_category_id'=>$articlecategory_id])->all();
    if($article){
        $result['data']=$article;
    }else{
        $result['msg']='该分类下没有文章';
    }
    return $result;
}
//-获取某文章所属分类
//6.购物车
//-添加商品到购物车
//-修改购物车某商品数量
//-删除购物车某商品
//-清空购物车
//-获取购物车所有商品
//7.订单
//-获取支付方式
//-获取送货方式
//-提交订单

//-修改密码
//-修改地址
//-地址列表
//-获取某分类的父分类
}