<?php

/**
 * @var yii\web\View $this
 */

?>

<?php if (Yii::$app->getSession()->hasFlash('gallery.success')): ?>
    <div class="alert alert-success">
        <p><?= Yii::$app->getSession()->getFlash('gallery.success') ?></p>
    </div>
<?php endif; ?>

<?php if (Yii::$app->getSession()->hasFlash('gallery.error')): ?>
    <div class="alert alert-danger">
        <p><?= Yii::$app->getSession()->getFlash('gallery.error') ?></p>
    </div>
<?php endif; ?>