<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 14:03
 * //商品表
 */
namespace backend\controllers;
use backend\models\Brand;
use backend\models\Gallery;
use backend\models\Goods;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsbController extends Controller{
    public $enableCsrfValidation=false;
    public function actionAdd(){
    $model= new Goods();
    $model2=new GoodsIntro();
        $model->goods_category_id=0;
        $request = new Request();
        if($request->isPost) {
            $model->load($request->post());
            $model2->load($request->post());
            if ($model->validate()&&$model2->validate()) {
               $model->create_time=time();
                $model->save(0);//$model->validate()
//                $onlyOne = $model->attributes['id'];

                $model2->goods_id = $model->id;
                $model2->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success', '添加成功');

//记录每日添加的商品数=========================================================================================
//记录每日添加的商品数=========================================================================================
//记录每日添加的商品数=========================================================================================
//                $daycount=new GoodsDayCount();
//                $time =date('Ymd',time());
//                $date = $daycount->find()->where(['day'=>$time])->one();
//               var_dump($date);exit;
////               var_dump(date('Ymd',$daycount->day));exit;
//                if($date){
//                    $daycount->count=$daycount->count+1;
//                    $daycount->save();
//
//                }else{
////                    $daycount=new GoodsDayCount();
//                    $daycount->day=date('Ymd',time());
//                    $daycount->count=1;
//                    $daycount->save();
//                }
                return $this->redirect(['goodsb/index']);

            }
        }
        //获取品牌分类
        $datas= Brand::find()->asArray()->all();
        $items=[];
        foreach($datas as $data){
            $items[$data['id']]=$data['name'];
        }
        return $this->render('add',['model'=>$model,'model2'=>$model2,'items'=>$items]);

        }

    public function actionIndex(){
        $goods=Goods::find();
        $pager = new Pagination();
        $pager->totalCount=$goods->count();
        $pager->pageSize=4;
        $name='';
        if(!empty($_GET['like'])){
            $name=$_GET['like'];
        }
        $goods = $goods->where(['like','name',$name])->limit($pager->limit)->offset($pager->offset)->all();
        //文章分类
//        var_dump($goods);exit;
        return $this->render('index',['goods'=>$goods,'pager'=>$pager]);

    }

    public function actionDelete($id){
        $goods = Goods::findOne(['id'=>$id]);

        $goods->delete();

        $this->redirect(['index']);
    }
    public function actionEdit($id){
        $model = Goods::findOne(['id'=>$id]);
        $model2=GoodsIntro::findOne(['goods_id'=>$id]);
        $request = \yii::$app->request;
        if($request->isPost) {
            $model->load($request->post());
            $model2->load($request->post());
            if ($model->validate()&&$model2->validate()) {
                $model->create_time=time();
                $model->save(0);//$model->validate()
//                $onlyOne = $model->attributes['id'];

                $model2->goods_id = $model->id;
                $model2->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success', '修改成功');

//                echo '添加成功';exit;
                return $this->redirect(['goodsb/index']);

            }
        }
        //获取品牌分类
        $datas= Brand::find()->asArray()->all();
        $items=[];
        foreach($datas as $data){
            $items[$data['id']]=$data['name'];
        }
        return $this->render('add',['model'=>$model,'model2'=>$model2,'items'=>$items]);

    }
//============================================================================================先不做
    //查询详细信息
    public function actionLook($id){

        $model = Goods::findOne(['id'=>$id]);
    $model2=GoodsIntro::findOne(['goods_id'=>$id]);
//var_dump($goods2);exit;
    return $this->render('look',['model2'=>$model2,'model'=>$model]);
}

    //处理文件上传的
    public function actionUpload()
    {
        if (\yii::$app->request->isPost) {
            //1111111111111111111111
            $imgFile = UploadedFile::getInstanceByName('file');
            //判断是否文件上传
            if ($imgFile) {
                $fileName = '/upload/' . uniqid() . '.' . $imgFile->extension;
                $imgFile->saveAs(\yii::getAlias('@webroot') . $fileName, 0);

                return Json_encode(['url' => $fileName]);
            }
        }
    }


}