Image galleries
===========
Yii2 module for image galleries with groups

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist wolfguard/yii2-gallery "*"
```

or add

```
"wolfguard/yii2-gallery": "*"
```

to the require section of your `composer.json` file.

After running 

```
php composer.phar update
```

run

```
yii migrate --migrationPath=@vendor/wolfguard/yii2-gallery/migrations
```

After that change your main configuration file ```config/web.php```

```php
<?php return [
    ...
    'modules' => [
        ...
        'gallery' => [
            'class' => 'wolfguard\gallery\Module',
        ],
        ...
    ],
    ...
];
```


Usage
-----

Once the extension is installed, simply use it in your code by:

```php
<?= \wolfguard\gallery\widgets\Gallery::widget(['code' => 'gallery-code']); ?>
```

or make your own widget!