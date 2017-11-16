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
use yii\data\Pagination;
use yii\web\Controller;

class GoodsController extends Controller{

    //商品列表
    public function actionIndex(){
        return $this->render('index');
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
}