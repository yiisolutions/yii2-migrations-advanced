<?php

namespace yiisolutions\migrations\db;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class RbacMigration extends Migration
{
    /**
     * Builds and executes a SQL statement for creating a new RBAC role.
     *
     * The columns in the new  table should be specified as name-definition pairs (e.g. 'name' => 'string'),
     * where name stands for a column name which will be properly quoted by the method, and definition
     * stands for the column type which can contain an abstract DB type.
     *
     * The [[QueryBuilder::getColumnType()]] method will be invoked to convert any abstract type into a physical one.
     *
     * If a column is specified with definition only (e.g. 'PRIMARY KEY (name, type)'), it will be directly
     * put into the generated SQL.
     *
     * @param string $name the name of the role to be created.
     * @param array $options the role options (name => value) in the new role.
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
     *
     * @throws Exception
     */
    public function dropRole($name)
    {
        echo "    > drop role $name ...";
        $time = microtime(true);
        $authManager = $this->getAuthManager();

        $role = $authManager->getRole($name);
        if (!$role) {
            throw new Exception("Failed to drop role '{$name}'. Role not found.");
        }
        $authManager->remove($role);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * @throws InvalidConfigException
     * @return DbManager
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
