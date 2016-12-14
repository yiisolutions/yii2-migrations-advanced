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
     * - `create_role`: role creating template
     * - `drop_role`: role dropping template
     * - `create_permission`: permission creating template
     * - `drop_permission`: permission dropping template
     */
    public $generatorTemplateFiles = [
        'create_role' => '@yiisolutions/migrations/../resources/views/rbac/createRoleMigration.php',
        'drop_role' => '@yiisolutions/migrations/../resources/views/rbac/dropRoleMigration.php',
        'create_permission' => '@yiisolutions/migrations/../resources/views/rbac/createPermissionMigration.php',
        'drop_permission' => '@yiisolutions/migrations/../resources/views/rbac/dropPermissionMigration.php',
    ];

    /**
     * @var string role or permission description
     */
    public $description;

    /**
     * @var string rule class name for role
     */
    public $ruleName;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['migrationTable', 'db'], // global for all actions
            $actionID === 'create'
                ? ['templateFile', 'description', 'ruleName']
                : []
        );
    }

    protected function generateMigrationSourceCode($params)
    {
        $name = $params['name'];

        $templateFile = $this->templateFile;
        $roleName = null;
        $permissionName = null;
        $options = [];
        if (preg_match('/^create_(.+)_role$/', $name, $matches)) {
            $templateFile = $this->generatorTemplateFiles['create_role'];
            $roleName = mb_strtolower($matches[1], Yii::$app->charset);

            if (!empty($this->description)) {
                $options['description'] = $this->description;
            }

            if (!empty($this->ruleName)) {
                $options['ruleName'] = $this->ruleName;
            }
        } elseif (preg_match('/^drop_(.+)_role$/', $name, $matches)) {
            $templateFile = $this->generatorTemplateFiles['drop_role'];
            $roleName = mb_strtolower($matches[1], Yii::$app->charset);

            $authManager = Yii::$app->getAuthManager();
            $role = $authManager->getRole($roleName);
            if ($role) {
                if (!empty($role->description)) {
                    $options['description'] = $role->description;
                }

                if (!empty($role->ruleName)) {
                    $options['ruleName'] = $role->ruleName;
                }
            }
        } elseif (preg_match('/^create_(.+)_permission$/', $name, $matches)) {
            $templateFile = $this->generatorTemplateFiles['create_permission'];
            $permissionName = mb_strtolower($matches[1], Yii::$app->charset);

            if (!empty($this->description)) {
                $options['description'] = $this->description;
            }

            if (!empty($this->ruleName)) {
                $options['ruleName'] = $this->ruleName;
            }
        } elseif (preg_match('/^drop_(.+)_permission$/', $name, $matches)) {
            $templateFile = $this->generatorTemplateFiles['drop_permission'];
            $permissionName = mb_strtolower($matches[1], Yii::$app->charset);

            $authManager = Yii::$app->getAuthManager();
            $permission = $authManager->getPermission($permissionName);
            if ($permission) {
                if (!empty($permission->description)) {
                    $options['description'] = $permission->description;
                }

                if (!empty($permission->ruleName)) {
                    $options['ruleName'] = $permission->ruleName;
                }
            }
        }

        return $this->renderFile(Yii::getAlias($templateFile), array_merge($params, [
            'roleName' => $roleName,
            'permissionName' => $permissionName,
            'options' => $options,
        ]));
    }
}
