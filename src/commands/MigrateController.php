<?php

namespace yiisolutions\migrations\commands;

use yii\console\controllers\MigrateController as BaseMigrateController;

class MigrateController extends BaseMigrateController
{
    public $templateFile = __DIR__ . '../../resources/views/migration.php';
}
