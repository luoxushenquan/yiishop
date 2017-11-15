<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/14
 * Time: 11:40
 */

namespace frontend\models;
use yii\db\ActiveRecord;

class GoodsCategory extends ActiveRecord{
    //首页显示商品分类
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

                //第一个一级分类需要加class = item1
                $html .= '<div class="cat '.($k1==0?'item1':'').'">
                    <h3><a href="">'.$category->name.'</a><b></b></h3>
                    <div class="cat_detail">';
                //遍历该一级分类的二级分类
                $categories2 = $category->children(1)->all();
                foreach ($categories2 as $k2=>$category2){
                    $html .= '<dl '.($k2==0?'class="dl_1st"':'').'>
                            <dt><a href="">'.$category2->name.'</a></dt>
                            <dd>';
                    //遍历该二级分类的三级分类
                    $categories3 = $category2->children(1)->all();
                    foreach ($categories3 as $category3){
                        $html .= '<a href="">'.$category3->name.'</a>';
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
