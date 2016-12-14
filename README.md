# yii2-migrations-advanced

Advanced migrations for Yii2

## Installation

Use composer 

```
composer require "yiisolutions/yii2-migrations-advanced: @dev"
```

or add to `composer.json` require section:

```
"yiisolutions/yii2-migrations-advanced": "@dev"
```

## Usage

Add custom migrate command in `config/console.php` file:

```php
<?php

return [
    // ...
    'controllerMap' => [
        'migrate' => [
            'class' => 'yiisolutions\migrations\commands\MigrateController',
            // your config options here ...
        ],
    ],
    // ...
];

```
