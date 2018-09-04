<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/jquery.Jcrop.min.css',
        'css/default.css',
        // 'css/main.css'
    ];
    public $js = [
        'js/jquery.Jcrop.min.js',
        //'js/jquery.min.js',
        'js/script.js',
        'js/resize.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
