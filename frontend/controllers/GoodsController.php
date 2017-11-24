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

    //��Ʒ�б�
    public function actionIndex(){
        //��ҳ��̬��
        //����ob����
        ob_start();
        //ҳ�������
        //��ȡob������
        //ob_get_contents();
        //�����ݱ��浽�����ļ� index.html
        //file_put_contents();
        $content = $this->render('index');
        //���浽��̬�ļ�
        file_put_contents('index.html',$content);
        return $content;
//        return $this->render('index');
    }
//ͨ��ajax��ȡ�û���¼״̬
public function actionUserStatus(){
    //���� ��¼״̬ �û���
    $isLogin=!\Yii::$app->user->isGuest;
    $username=$isLogin?\Yii::$app->user->identity->username:'';
    return['isLogin'=>$isLogin,'username'=>$username];
}

    public function actionList($goods_category_id){
//          var_dump($goods_category_id) ;exit;
        $goods_category = GoodsCategory::findOne(['id'=>$goods_category_id]);
//        var_dump($goods_category);exit;
        //��������

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
    //���ķִ�����
    public function actionSearch(){
//        require ( "sphinxapi.php" );
        $cl = new SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);//sphinx��searchd������Ϣ
        $cl->SetConnectTimeout ( 10 );//��ʱ
        $cl->SetArrayResult ( true );//���������ʽ����
// $cl->SetMatchMode ( SPH_MATCH_ANY);
        $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);//����ƥ��ģʽ
        $cl->SetLimits(0, 1000);//���÷�ҳ
        $info = 'С��';//��ѯ�ؼ���
        $res = $cl->Query($info, 'goods');//shopstore_search
//print_r($cl);
        print_r($res);
//    var_dump($res);
    }


}