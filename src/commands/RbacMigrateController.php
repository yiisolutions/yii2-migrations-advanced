<?php

namespace yiisolutions\migrations\commands;

use Yii;
use yii\console\controllers\MigrateController as BaseMigrateController;

class RbacMigrateController extends BaseMigrateController
{
    public $migrationTable = '{{%rbac_migration}}';
    public $migrationPath = '@app/rbac';
    public $templateFile = '@yiisolutions/migrations/../resources/views/rbac/migration.php';

    /**
     * @var array a set of template paths for generating migration code automatically.
     *
     * The key is the template type, the value is a path or the alias. Supported types are:
     * - `create_table`: table creating template
     * - `drop_table`: table dropping template
     * - `add_column`: adding new column template
     * - `drop_column`: dropping column template
     * - `create_junction`: create junction template
     *
     * @since 2.0.7
     */
    public $generatorTemplateFiles = [
        'create_role' => '@yiisolutions/migrations/../resources/views/rbac/createRoleMigration.php',
        'drop_role' => '@yiisolutions/migrations/../resources/views/rbac/dropRoleMigration.php',
    ];

    protected function generateMigrationSourceCode($params)
    {
        $name = $params['name'];

        $templateFile = $this->templateFile;
        $roleName = null;
        if (preg_match('/^create_(.+)_role$/', $name, $matches)) {
            $templateFile = $this->generatorTemplateFiles['create_role'];
            $roleName = mb_strtolower($matches[1], Yii::$app->charset);
        } elseif (preg_match('/^drop_(.+)_role$/', $name, $matches)) {
            $templateFile = $this->generatorTemplateFiles['drop_role'];
            $roleName = mb_strtolower($matches[1], Yii::$app->charset);
        }

        return $this->renderFile(Yii::getAlias($templateFile), array_merge($params, [
            'roleName' => $roleName,
            'options' => [],
        ]));
    }
}
