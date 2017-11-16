<?php
namespace backend\models;
use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property integer $parent_id
 * @property string $intro
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'parent_id'], 'required'],
            [['tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => '商品名',
            'parent_id' => '商品分类',
            'intro' => '简介',
        ];
    }
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',//必须打开多棵树
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    public static function find()
    {
        return new GoodsCategoryQuery(get_called_class());
    }
    //获取数据
    public static function getZtreeNodes(){
        return $categoreys = self::find()->select(['id','name','parent_id'])->all();
    }


    public static function getIndexGoodsCategory(){

        //使用redis进行性能优化(后台改变商品分类[添加修改删除],需要清除redis缓存)
        //缓存使用 先读缓存,有就直接用,没有就重写生成
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
    }
}