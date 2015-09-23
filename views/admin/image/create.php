<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var wolfguard\gallery\models\Gallery $gallery
 * @var wolfguard\gallery\models\GalleryImage $model
 */

$this->title = Yii::t('gallery', 'Create image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $gallery->name, 'url' => ['update', 'id' => $gallery->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Images'), 'url' => ['images', 'id' => $gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('/admin/flash') ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['options' => [
            'enctype' => 'multipart/form-data',
        ]]); ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <?= $form->field($model, 'alt')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

        <?= $form->field($model, 'sort')->textInput(['maxlength' => 255]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('gallery', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
