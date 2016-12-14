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

### RBAC migrations

Sometimes you need to create a migration for RBAC. Use RbacMigrateController for this:
  
```php
<?php

return [
    // ...
    'controllerMap' => [
        'rbac-migrate' => [
            'class' => 'yiisolutions\migrations\commands\RbacMigrateController',
        ],    
    ],
    // ...
];
```

For `rbac-migrate/create` command available templates:

* `create_[name]_role` - create new role migration (options: description, ruleName)
* `drop_[name]_role` - drop exist role migration
* `create_[name]_permission` - create new permission migration (options: description, ruleName)
* `drop_[name]_permission` - drop exist permission migration.

