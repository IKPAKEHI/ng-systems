<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "Categories".
 *
 * @property int $id
 * @property string $name
 */
class Categories_goods extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Categories_goods';
    }
}
