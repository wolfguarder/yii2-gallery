<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var wolfguard\gallery\models\Gallery $model
 */

$this->title = Yii::t('gallery', 'Create gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('flash') ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="alert alert-info">
            <?= Yii::t('gallery', 'Be careful in Code field. Pay attention to field hint.') ?>
        </div>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => 255])->hint(Yii::t('gallery', 'Only latin characters, numbers and symbols (.-_) allowed. Spaces not allowed.')) ?>

        <?= $form->field($model, 'description')->textarea() ?>

        <?= $form->field($model, 'sort')->textInput(['maxlength' => 255]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('gallery', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
