<?php

namespace wolfguard\gallery\helpers;

/**
 * @property \wolfguard\gallery\Module $module
 */
trait ModuleTrait
{
    /**
     * @var null|\wolfguard\gallery\Module
     */
    private $_module;

    /**
     * @return null|\wolfguard\gallery\Module
     */
    protected function getModule()
    {
        if ($this->_module == null) {
            $this->_module = \Yii::$app->getModule('gallery');
        }

        return $this->_module;
    }
}