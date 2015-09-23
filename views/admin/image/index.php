<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var wolfguard\gallery\models\GalleryImageSearch $searchModel
 * @var wolfguard\gallery\models\Gallery $gallery
 */

$this->title = Yii::t('gallery', 'Manage images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $gallery->name, 'url' => ['update', 'id' => $gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title). ': ' . $gallery->name ?> <?= Html::a(Yii::t('gallery', 'Create image'), ['create-image', 'id' => $gallery->id], ['class' => 'btn btn-success']) ?></h1>

<?php echo $this->render('/admin/flash') ?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'file',
            'format' => 'html',
            'value' => function ($model) {
                return Html::img($model->getThumbFileUrl('file', 'small'));
            },
            'filter' => false,
        ],
        'alt',
        'sort',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::t('gallery', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
            },
            'filter' => false,
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update-image} {delete-image}',
            'buttons' => [
                'update-image' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Yii::t('yii', 'Update'),
                        'aria-label' => Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                    ]);
                },
                'delete-image' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                },
            ],
        ],
    ],
]); ?>
