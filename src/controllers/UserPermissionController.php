<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\user\controllers;

use gearsoftware\controllers\BaseController;
use gearsoftware\models\Permission;
use gearsoftware\models\Role;
use gearsoftware\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class UserPermissionController extends BaseController
{

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionSet($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException(Yii::t('core/user', 'User not found'));
        }

        $permissionsByGroup = [];
        $permissions = Permission::find()
            ->andWhere([
                Yii::$app->core->auth_item_table . '.name' => array_keys(Permission::getUserPermissions($user->id))
            ])
            ->joinWith('group')
            ->all();

        foreach ($permissions as $permission) {
            $permissionsByGroup[@$permission->group->name][] = $permission;
        }

        return $this->renderIsAjax('set', compact('user', 'permissionsByGroup'));
    }

    /**
     * @param int $id - User ID
     *
     * @return \yii\web\Response
     */
    public function actionSetRoles($id)
    {
        if (!Yii::$app->user->isSuperadmin AND Yii::$app->user->id == $id) {
            Yii::$app->session->setFlash('warning', Yii::t('core/user', 'You can not change own permissions'));
            return $this->redirect(['set', 'id' => $id]);
        }

        $oldAssignments = array_keys(Role::getUserRoles($id));

        // To be sure that user didn't attempt to assign himself some unavailable roles
        $newAssignments = array_intersect(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin, true), Yii::$app->request->post('roles', []));

        $toAssign = array_diff($newAssignments, $oldAssignments);
        $toRevoke = array_diff($oldAssignments, $newAssignments);

        foreach ($toRevoke as $role) {
            User::revokeRole($id, $role);
        }

        foreach ($toAssign as $role) {
            User::assignRole($id, $role);
        }

        Yii::$app->session->setFlash('mint', Yii::t('core', 'The changes have been saved.'));

        return $this->redirect(['set', 'id' => $id]);
    }

}
