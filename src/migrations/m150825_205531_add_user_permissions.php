<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\db\PermissionsMigration;

class m150825_205531_add_user_permissions extends PermissionsMigration
{

    public function beforeUp()
    {
        $this->addPermissionsGroup('userManagement', 'User Management');
    }

    public function afterDown()
    {
        $this->deletePermissionsGroup('userManagement');
    }

    public function getPermissions()
    {
        return [
            'userManagement' => [
                'links' => [
                    '/admin/user/*',
                    '/admin/user/default/*',
                    '/admin/user/role/*',
                    '/admin/user/permission/*',
                    '/admin/user/permission-groups/*',
                    '/admin/user/user-permission/*',
                    '/admin/user/visit-log/*',
                ],
                'viewUsers' => [
                    'title' => 'View Users',
                    'roles' => [self::ROLE_SUPPORT],
                    'links' => [
                        '/admin/user/default/index',
                        '/admin/user/default/grid-sort',
                        '/admin/user/default/grid-page-size',
                    ],
                ],
                'editUsers' => [
                    'title' => 'Edit Users',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers'],
                    'links' => [
                        '/admin/user/default/update',
                        '/admin/user/default/bulk-activate',
                        '/admin/user/default/bulk-deactivate',
                        '/admin/user/default/toggle-attribute',
                    ],
                ],
                'createUsers' => [
                    'title' => 'Create Users',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers'],
                    'links' => [
                        '/admin/user/default/create',
                    ],
                ],
                'deleteUsers' => [
                    'title' => 'Delete Users',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers'],
                    'links' => [
                        '/admin/user/default/delete',
                        '/admin/user/default/bulk-delete',
                    ],
                ],
                'changeUserPassword' => [
                    'title' => 'Change User Password',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers'],
                    'links' => [
                        '/admin/user/default/change-password',
                    ],
                ],
                'viewRolesAndPermissions' => [
                    'title' => 'View Roles And Permissions',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers', 'viewUserRoles'],
                    'links' => [
                        '/admin/user/permission-groups/index',
                        '/admin/user/permission-groups/grid-sort',
                        '/admin/user/permission-groups/grid-page-size',
                        '/admin/user/permission/index',
                        '/admin/user/permission/grid-sort',
                        '/admin/user/permission/grid-page-size',
                        '/admin/user/role/index',
                        '/admin/user/role/grid-sort',
                        '/admin/user/role/grid-page-size',
                    ],
                ],
                'manageRolesAndPermissions' => [
                    'title' => 'Manage Roles And Permissions',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewRolesAndPermissions', 'viewUsers', 'editUsers'],
                    'links' => [
                        '/admin/user/permission-groups/update',
                        '/admin/user/permission-groups/create',
                        '/admin/user/permission-groups/delete',
                        '/admin/user/permission-groups/bulk-delete',
                        '/admin/user/permission/update',
                        '/admin/user/permission/create',
                        '/admin/user/permission/delete',
                        '/admin/user/permission/bulk-delete',
                        '/admin/user/permission/view',
                        '/admin/user/permission/refresh-routes',
                        '/admin/user/permission/set-child-permissions',
                        '/admin/user/permission/set-child-routes',
                        '/admin/user/role/update',
                        '/admin/user/role/create',
                        '/admin/user/role/delete',
                        '/admin/user/role/bulk-delete',
                        '/admin/user/role/view',
                        '/admin/user/role/set-child-permissions',
                        '/admin/user/role/set-child-roles',
                    ],
                ],
                'assignRolesToUsers' => [
                    'title' => 'Assign Roles To Users',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers', 'viewUserRoles'],
                    'links' => [
                        '/admin/user/user-permission/set',
                        '/admin/user/user-permission/set-roles',
                    ],
                ],
                'viewVisitLog' => [
                    'title' => 'View Visit Logs',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUsers'],
                    'links' => [
                        '/admin/user/visit-log/index',
                        '/admin/user/visit-log/view',
                        '/admin/user/visit-log/grid-sort',
                        '/admin/user/visit-log/grid-page-size',
                    ],
                ],
                'bindUserToIp' => [
                    'title' => 'Bind User To IP',
                    'roles' => [self::ROLE_PRINCIPAL],
                ],
                'editUserEmail' => [
                    'title' => 'Edit User Email',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewUserEmail'],
                ],
                'viewRegistrationIp' => [
                    'title' => 'View Registration IP',
                    'roles' => [self::ROLE_PRINCIPAL],
                ],
                'viewUserEmail' => [
                    'title' => 'View User Email',
                    'roles' => [self::ROLE_SUPPORT],
                ],
                'viewUserRoles' => [
                    'title' => 'View User Roles',
                    'roles' => [self::ROLE_PRINCIPAL],
                ],
            ],
        ];
    }

}
