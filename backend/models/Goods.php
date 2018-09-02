<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use backend\models\Categories_goods;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $description
 * @property string $img
 */
class Goods extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $categories;

    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'description', 'categories'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['price'], 'string', 'max' => 10],
            [['description', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'price' => 'Цена',
            'description' => 'Описание',
            'img' => 'Введите урл картинки',
            'categories' => 'Категории',
        ];
    }
    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $iWidth = $iHeight = 200; // desired image result dimensions
            $iJpgQuality = 90;
            if ($_FILES && isset($_FILES['image_file'])) {
                // if no errors and size less than 250kb
                if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
                    if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                        // new unique filename
                        $sTempFileName = 'uploads/' . md5(time().rand());
                        $this->img = $sTempFileName;
                        // move uploaded file into cache folder
                        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
                        // change file permission to 644
                        @chmod($sTempFileName, 0644);
                        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                            $aSize = getimagesize($sTempFileName); // try to obtain image info
                            if (!$aSize) {
                                @unlink($sTempFileName);
                                return;
                            }
                            switch($aSize[2]) {
                                case IMAGETYPE_JPEG:
                                    $sExt = '.jpg';
                                    $vImg = @imagecreatefromjpeg($sTempFileName);
                                    break;
                                case IMAGETYPE_PNG:
                                    $sExt = '.png';
                                    $vImg = @imagecreatefrompng($sTempFileName);
                                    break;
                                default:
                                    @unlink($sTempFileName);
                                    return;
                            }
                            // create a new true color image
                            $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
                            // copy and resize part of an image with resampling
                            imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
                            // define a result image filename
                            $sResultFileName = $sTempFileName . $sExt;
                            // output image to file
                            imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                            @unlink($sTempFileName);
                            return $sResultFileName;
                        }
                    }
                }
            }
        }
    }

    public function add_good_to_categories()
    {
        $model = Categories_goods::find()->all();

        var_dump($model['0']['good_id']);
    }
}
