<?php

return [
    'class' => \yii\console\Application::class,
    'id' => 'yii2-phpfpm-test',
    'basePath' => __DIR__ . '/../src',
    'modules' => [
        'staticAssets' => [
            'class' => \SamIT\Yii2\StaticAssets\Module::class,
        ]
    ]
];