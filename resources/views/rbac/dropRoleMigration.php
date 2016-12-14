<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */
/* @var $roleName string the name table */
/* @var $options array the options */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yiisolutions\migrations\db\RbacMigration;

/**
 * Handles the dropping of role `<?= $roleName ?>`.
 */
class <?= $className ?> extends RbacMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropRole('<?= $roleName ?>');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    <?php if (empty($options)): ?>
        $this->createRole('<?= $roleName ?>');
    <?php else: ?>
        $this->createRole('<?= $roleName ?>, [
        <?php foreach ($options as $key => $value): ?>
            '<?= $key ?>' => '<?= $value ?>',
        <?php endforeach; ?>
        ]);
    <?php endif ?>
    }
}
