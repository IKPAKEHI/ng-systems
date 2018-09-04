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
            [['price'], 'integer', 'min' => 1, 'max' => 100000],
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
            'img' => 'Картинка',
            'categories' => 'Категории',
        ];
    }

    public function imageresize($outfile,$infile,$neww,$newh,$quality) {
        $vDstImg= @imagecreatetruecolor($neww,$newh);
        imagecopyresampled($vDstImg,$infile,0,0,0,0,$neww,$newh,imagesx($infile),imagesy($infile));
        return ($vDstImg);
    }


    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $iWidth = $iHeight = 300; // desired image result dimensions
            $iJpgQuality = 90;
            if ($_FILES && isset($_FILES['image_file'])) {
                // if no errors and size less than 250kb
                if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
                    if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                        // new unique filename
                        $sTempFileName = '../../frontend/web/uploads/' . md5(time().rand());
                        $this->img = str_replace('../../frontend/web/','', $sTempFileName) . '.jpg';
                        // move uploaded file into cache folder
                        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
                        // change file permission to 644
                        @chmod($sTempFileName, 0644);
                        echo "<br><br><br>";
                        var_dump($_POST);
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
                            $vImg = Goods::imageresize("uploads/qwe.jpg",$vImg , intval($_POST['img_width']), intval($_POST['img_height']), 75);
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
        $values_arr = array();
        $values_arr[] = ['1', $this['id']];
        foreach ($_POST['Goods']['categories'] as $categorie) {
            $values_arr[] = [$categorie, $this['id']];
        }
        Yii::$app->db->createCommand()->batchInsert('categories_goods', ['categorie_id','good_id'], $values_arr)->execute();
    }
}
