<?php

namespace yiisolutions\migrations\db;

use yii\db\Migration as BaseMigration;

class Migration extends BaseMigration
{
    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if ($options === null) {
            if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
        }

        parent::createTable($table, $columns, $options);
    }
}
