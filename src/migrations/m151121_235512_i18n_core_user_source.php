<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\db\SourceMessagesMigration;

class m151121_235512_i18n_core_user_source extends SourceMessagesMigration
{

    public function getCategory()
    {
        return 'core/user';
    }

    public function getMessages()
    {
        return [
            'Child permissions' => 1,
            'Child roles' => 1,
            'Create Permission Group' => 1,
            'Create Permission' => 1,
            'Create Role' => 1,
            'Create User' => 1,
            'Log №{id}' => 1,
            'No users found.' => 1,
            'Password' => 1,
            'Permission Groups' => 1,
            'Permission' => 1,
            'Permissions for "{role}" role' => 1,
            'Permissions' => 1,
            'Refresh routes' => 1,
            'Registration date' => 1,
            'Role' => 1,
            'Roles and Permissions for "{user}"' => 1,
            'Roles' => 1,
            'Routes' => 1,
            'Search route' => 1,
            'Show all' => 1,
	        'Show all elements' => 1,
            'Show only selected' => 1,
            'Update Permission Group' => 1,
            'Update Permission' => 1,
            'Update Role' => 1,
            'Update User Password' => 1,
            'Update User' => 1,
            'User not found' => 1,
            'User' => 1,
            'Users' => 1,
            'Visit Log' => 1,
            'You can not change own permissions' => 1,
            "You can't update own permissions!" => 1,
            '{permission} Permission Settings' => 1,
            '{permission} Role Settings' => 1,
	        'Refresh routes (and delete unused)' => 1,
        ];
    }
}