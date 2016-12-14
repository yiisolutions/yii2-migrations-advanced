<?php
/**
 * This view is used by console/controllers/MigrateController.php
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
 * Handles the dropping of permission `<?= $permissionName ?>`.
 */
class <?= $className ?> extends RbacMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropPermission('<?= $permissionName ?>');
    }

    /**
     * @inheritdoc
     */
    public function down()
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
}
