<?php

namespace wolfguard\gallery\widgets;

use wolfguard\gallery\helpers\ModuleTrait;
use yii\base\Widget;

/**
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class Gallery extends Widget
{
    use ModuleTrait;

    /**
     * @var string
     */
    public $code = '';

    /**
     * @var bool
     */
    public $visible = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->code)) {
            $this->visible = false;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->visible) return false;

        $model = $this->module->manager->findGalleryByCode($this->code);

        if (!$model) {
            return \Yii::t('gallery', 'There is no gallery with code "{code}"', ['{code}' => $this->code]);
        }

        $images = $model->getImages()->all();

        return $this->render('gallery/gallery', [
            'model' => $model,
            'images' => $images
        ]);
    }
}