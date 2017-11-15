<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/14
 * Time: 21:44
 */
namespace frontend\controllers;
use backend\models\Goods;
use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\web\Controller;

class GoodsController extends Controller{

    //商品列表
    public function actionList(){
        //商品分类  一级  二级  三级
        $goods_category_id=4;
        $goods_category = GoodsCategory::findOne(['id'=>$goods_category_id]);
        //三级分类
        if($goods_category->depth == 2){
            $query = Goods::find()->where(['goods_category_id'=>$goods_category_id]);

        }else{
            //二级分类  14
            //获取二级分类下面的所有三级分类 17,18
            //根据三级分类id[17,18,20,21,22,9999]查商品
            // sql: select * from goods where goods_category_id=17 or goods_category_id=18 or goods_category_id=18 or goods_category_id=18 or goods_category_id=18 or goods_category_id=18 or goods_category_id=18 or goods_category_id=18
            //select * from goods where  goods_category_id in (17,18,29...999)
            /*$result = $goods_category->children(1)->all();
            //var_dump($result);exit;
            $ids = [];
            foreach ($result as $category){
                $ids[] = $category->id;
            }*/
            //sql:select * from goodscategory where parent_id=14
            //$ids = $goods_category->children()->andWhere(['depth'=>2])->column();
            $ids = $goods_category->children()->andWhere(['depth'=>2])->column();
            //$goods_category->children(1)->
            //$ids = [17,18];
            //var_dump($ids);exit;
            $query = Goods::find()->where(['in','goods_category_id',$ids]);

        }/*elseif ($goods_category->depth == 0){
            //一级分类
            $ids = $goods_category->children(2)->andWhere(['depth'=>2])->column();
            var_dump($ids);exit;
        }*/

        $pager = new Pagination();
        $pager->totalCount = $query->count();
        $pager->pageSize = 20;

        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
}