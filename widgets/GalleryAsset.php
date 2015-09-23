<?php

namespace wolfguard\gallery\widgets;

use yii\web\AssetBundle;

/**
* Gallery asset bundle
*
* @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
*/
class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@vendor/wolfguard/yii2-gallery/widgets/views/gallery/assets';
    public $css = [
        'gallery.css',
    ];
    public $js = [
        'gallery.js',
    ];
}