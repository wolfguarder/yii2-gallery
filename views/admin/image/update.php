<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var wolfguard\gallery\models\Gallery $gallery
 * @var wolfguard\gallery\models\GalleryImage $model
 */

$this->title = Yii::t('gallery', 'Update image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $gallery->name, 'url' => ['update', 'id' => $gallery->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Images'), 'url' => ['images', 'id' => $gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title . ': ' . Html::encode($model->id) ?></h1>

<?php echo $this->render('/admin/flash') ?>

<div class="panel panel-info">
    <div class="panel-heading"><?= Yii::t('gallery', 'Information') ?></div>
    <div class="panel-body">
        <?= Yii::t('gallery', 'Created at {0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]) ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['options' => [
            'enctype' => 'multipart/form-data',
        ]]); ?>

        <?php if(!empty($model->file)):?>
            <?= Html::img($model->getThumbFileUrl('file', 'small')) ?>
        <? endif; ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <?= $form->field($model, 'alt')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

        <?= $form->field($model, 'sort')->textInput(['maxlength' => 255]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('gallery', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
