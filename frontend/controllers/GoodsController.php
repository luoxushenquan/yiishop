<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/14
 * Time: 21:44
 */
namespace frontend\controllers;

use backend\controllers\GalleryController;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use frontend\models\SphinxClient;
use yii\data\Pagination;
use yii\web\Controller;

class GoodsController extends Controller{

    //商品列表
    public function actionIndex(){
        //首页静态化
        //开启ob缓存
        ob_start();
        //页面输出啊
        //获取ob缓存内
        //ob_get_contents();
        //将内容保存到今天文件 index.html
        //file_put_contents();
        $content = $this->render('index');
        //保存到静态文件
        file_put_contents('index.html',$content);
        return $content;
//        return $this->render('index');
    }
//通过ajax获取用户登录状态
public function actionUserStatus(){
    //返回 登录状态 用户名
    $isLogin=!\Yii::$app->user->isGuest;
    $username=$isLogin?\Yii::$app->user->identity->username:'';
    return['isLogin'=>$isLogin,'username'=>$username];
}

    public function actionList($goods_category_id){
//          var_dump($goods_category_id) ;exit;
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

        }
        $pager = new Pagination();
        $pager->totalCount = $query->count();
        $pager->pageSize = 10;

        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
//        var_dump($models);exit;
        return $this->render('list',['models'=>$models,'pager'=>$pager]);
    }

    public function actionLook($id){
        $model= GoodsGallery::find()->where(['goods_id'=>$id])->all();
        $model2= Goods::findOne(['id'=>$id]);
//        var_dump($model);exit;
        return $this->render('look',['model'=>$model,'model2'=>$model2]);
    }
    //中文分词搜索
    public function actionSearch(){
//        require ( "sphinxapi.php" );
        $cl = new SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);//sphinx的searchd服务信息
        $cl->SetConnectTimeout ( 10 );//超时
        $cl->SetArrayResult ( true );//结果数组形式返回
// $cl->SetMatchMode ( SPH_MATCH_ANY);
        $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);//设置匹配模式
        $cl->SetLimits(0, 1000);//设置分页
        $info = '小米';//查询关键字
        $res = $cl->Query($info, 'goods');//shopstore_search
//print_r($cl);
        print_r($res);
//    var_dump($res);
    }


}