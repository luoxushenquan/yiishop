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

    //��Ʒ�б�
    public function actionList(){
        //��Ʒ����  һ��  ����  ����
        $goods_category_id=4;
        $goods_category = GoodsCategory::findOne(['id'=>$goods_category_id]);
        //��������
        if($goods_category->depth == 2){
            $query = Goods::find()->where(['goods_category_id'=>$goods_category_id]);

        }else{
            //��������  14
            //��ȡ������������������������� 17,18
            //������������id[17,18,20,21,22,9999]����Ʒ
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
            //һ������
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