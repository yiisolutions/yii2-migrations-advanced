<?php

namespace yiisolutions\migrations\commands;

use yii\console\controllers\MigrateController as BaseMigrateController;

class MigrateController extends BaseMigrateController
{
    public $templateFile = '@yiisolutions/migrations/../resources/views/migration.php';

    public $generatorTemplateFiles = [
        'create_table' => '@yiisolutions/migrations/../resources/views/createTableMigration.php',
        'drop_table' => '@yiisolutions/migrations/../resources/views/dropTableMigration.php',
        'add_column' => '@yiisolutions/migrations/../resources/views/addColumnMigration.php',
        'drop_column' => '@yiisolutions/migrations/../resources/views/dropColumnMigration.php',
        'create_junction' => '@yiisolutions/migrations/../resources/views/createTableMigration.php',
    ];
}
