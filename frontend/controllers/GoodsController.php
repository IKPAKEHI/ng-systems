<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use frontend\models\Goods;
use frontend\models\Categories;
use frontend\models\Categories_goods;

class GoodsController extends Controller
{
    public function actionIndex($id = 1)
    {
        $all_goods_query = Goods::find();
        $all_categs_query = Categories::find();
        $commun_categs_goods = Categories_goods::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $all_goods_query->count()
        ]);


        $id_of_goods_by_categ = $commun_categs_goods
        ->select(['good_id'])
        ->where(['categorie_id' => $id])
        ->all();

        $or_array = array();
        $or_array[] = 'OR';
        foreach ($id_of_goods_by_categ as $id_of_good) {
            $or_array[] = ['id' => $id_of_good];
        }

        $goods_by_categ = $all_goods_query
        ->where($or_array)
        ->all();

        $all_categs = $all_categs_query
        ->all();
        return ($this->render('index', 
            [
                'goods_by_categ' => $goods_by_categ,
                'pagination' => $pagination,
                'all_categs' => $all_categs,
                'id_of_goods_by_categ' => $id_of_goods_by_categ,
            ]
        ));
    }
}