<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Categories".
 *
 * @property int $id
 * @property string $name
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function listCategories()
    {
        $all_categs_query = Categories::find();
        $ids = $all_categs_query
        ->select('id')
        ->where(['not like', 'id', ['1']])
        ->column();
        $names = $all_categs_query
        ->select('name')
        ->where(['not like', 'id', ['1']])
        ->column();

        $add_to_categorie = array();
        $i = 0;
        foreach ($ids as $id) {
            $add_to_categorie["$id"] = $names[$i++];
        }
        return $add_to_categorie;
    }
}
