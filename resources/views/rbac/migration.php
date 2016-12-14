<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yiisolutions\migrations\db\RbacMigration;

class <?= $className ?> extends RbacMigration
{
    public function up()
    {
        $authManager = $this->getAuthManager();


    }

    public function down()
    {
        $authManager = $this->getAuthManager();

        echo "<?= $className ?> cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $authManager = $this->getAuthManager();

    }

    public function safeDown()
    {
        $authManager = $this->getAuthManager();

    }
    */
}
