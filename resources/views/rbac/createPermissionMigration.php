<?php
/**
 * This view is used by src/commands/RbacMigrateController.php.
 *
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */
/* @var $permissionName string the name permission */
/* @var $options array the options */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yiisolutions\migrations\db\RbacMigration;

/**
 * Handles the creation of permission `<?= $permissionName ?>`.
 */
class <?= $className ?> extends RbacMigration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
<?php if (empty($options)): ?>
        $this->createPermission('<?= $permissionName ?>');
<?php else: ?>
        $this->createPermission('<?= $permissionName ?>', [
<?php foreach ($options as $key => $value): ?>
            '<?= $key ?>' => '<?= $value ?>',
<?php endforeach; ?>
        ]);
<?php endif ?>
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropPermission('<?= $permissionName ?>');
    }
}
