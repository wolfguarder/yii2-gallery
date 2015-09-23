<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use wolfguard\gallery\widgets\GalleryAsset;

/**
 * @var yii\web\View $this
 * @var wolfguard\gallery\models\Gallery $model
 * @var wolfguard\gallery\models\GalleryImage[] $images
 */
?>
<?php GalleryAsset::register($this); ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <div class="inline-gallery-admin">
    <?= Html::a(Yii::t('gallery', 'Edit'), ['/gallery/admin/images', 'id' => $model->id], [
        'class' => 'btn btn-success',
        'onclick' => 'galleryAddReturnUrl(this);'
    ]) ?>
<?php endif ?>

<?php foreach ($images as $image): ?>
    <?= Html::img(EasyThumbnailImage::thumbnailFileUrl($image->getUploadedFilePath('file'), 200, 200, EasyThumbnailImage::THUMBNAIL_OUTBOUND), ['class' => 'img-circle']); ?>
<?php endforeach; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    </div>
<?php endif ?>