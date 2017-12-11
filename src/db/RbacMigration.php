<?php

namespace yiisolutions\migrations\db;

use Yii;
use yiisolutions\migrations\exceptions\RbacMigrationException;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class RbacMigration extends Migration
{
    /**
     * Builds and executes a SQL statement for creating a new RBAC role.
     *
     * @param string $name the name of the role to be created.
     * @param array $options the role options (name => value) in the new role.
     * @throws InvalidConfigException
     */
    public function createRole($name, array $options = [])
    {
        echo "    > create role: $name ...";
        $time = microtime(true);
        $authManager = $this->getAuthManager();
        $role = $authManager->createRole($name);

        if (isset($options['description'])) {
            $role->description = $options['description'];
        }

        if (isset($options['ruleName'])) {
            $role->ruleName = $options['ruleName'];
        }

        $authManager->add($role);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Builds and executes a SQL statement for dropping a RBAC role.
     *
     * @param string $name the role to be dropped.
     * @throws RbacMigrationException
     * @throws InvalidConfigException
     */
    public function dropRole($name)
    {
        echo "    > drop role $name ...";
        $time = microtime(true);
        $authManager = $this->getAuthManager();

        $role = $authManager->getRole($name);
        if (!$role) {
            throw new RbacMigrationException("Failed to drop role '{$name}'. Role not found.");
        }
        $authManager->remove($role);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Builds and executes a SQL statement for creating a new RBAC permission.
     *
     * @param string $name the name of the permission to be created.
     * @param array $options the permission options (name => value) in the new permission.
     * @throws InvalidConfigException
     */
    public function createPermission($name, $options)
    {
        echo "    > create permission $name ...";
        $time = microtime(true);
        $authManager = $this->getAuthManager();

        $permission = $authManager->createPermission($name);

        if (isset($options['description'])) {
            $permission->description = $options['description'];
        }

        if (isset($options['ruleName'])) {
            $permission->ruleName = $options['ruleName'];
        }

        $authManager->add($permission);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Builds and executes a SQL statement for dropping a RBAC permission.
     *
     * @param string $name the permission to be dropped.
     * @throws InvalidConfigException
     * @throws RbacMigrationException
     */
    public function dropPermission($name)
    {
        echo "    > drop permission $name ...";
        $time = microtime(true);
        $authManager = $this->getAuthManager();

        $permission = $authManager->getPermission($name);
        if (!$permission) {
            throw new RbacMigrationException("Failed to drop permission '{$name}'. Permission not found.");
        }
        $authManager->remove($permission);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Access to auth manager.
     *
     * @return DbManager
     * @throws InvalidConfigException
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }
}
