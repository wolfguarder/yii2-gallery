<?php

namespace wolfguard\gallery;

use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

/**
 * Bootstrap class registers module and block application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (!$app->hasModule('gallery')) {
            $app->setModule('gallery', [
                'class' => 'wolfguard\gallery\Module'
            ]);
        }

        /** @var $module Module */
        $module = $app->getModule('gallery');

        if ($app instanceof \yii\console\Application) {
            $module->controllerNamespace = 'wolfguard\gallery\commands';
        } else {
            $configUrlRule = [
                'prefix' => $module->urlPrefix,
                'rules'  => $module->urlRules
            ];

            if ($module->urlPrefix != 'gallery') {
                $configUrlRule['routePrefix'] = 'gallery';
            }

            $app->get('urlManager')->rules[] = new GroupUrlRule($configUrlRule);
        }

        $app->get('i18n')->translations['gallery*'] = [
            'class'    => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
        ];
    }
}