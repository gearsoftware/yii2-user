<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

/**
 * @var gearsoftware\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */

use gearsoftware\helpers\Html;
use gearsoftware\models\Role;
use gearsoftware\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('core/user', '{permission} Role Settings', ['permission' => $role->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Roles'), 'url' => ['/user/role/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('core', 'Edit'), ['update', 'id' => $role->name], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('core', 'Create'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span
                            class="glyphicon glyphicon-th"></span> <?= Yii::t('core/user', 'Child roles') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-roles', 'id' => $role->name]) ?>

	                <?php foreach ($allRoles as $aRole): ?>
                        <label>
			                <?php $isChecked = in_array($aRole['name'], ArrayHelper::map($childRoles, 'name', 'name')) ? 'checked' : '' ?>
                            <input type="checkbox" <?= $isChecked ?> name="child_roles[]" value="<?= $aRole['name'] ?>">
			                <?= $aRole['description'] ?>
                        </label>

		                <?= Html::a(
		                '<span class="glyphicon glyphicon-edit"></span>',
		                ['/user/role/view', 'id'=>$aRole['name']],
		                ['target'=>'_blank']
	                ) ?>
                        <br/>
	                <?php endforeach ?>

                    <hr/>
                    <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                        <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php endif; ?>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <?= Yii::t('core/user', 'Permissions') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-permissions', 'id' => $role->name]) ?>

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>
	                                <?php foreach ($permissions as $permission): ?>
                                        <label>
			                                <?php $isChecked = in_array($permission->name, ArrayHelper::map($currentPermissions, 'name', 'name')) ? 'checked' : '' ?>
                                            <input type="checkbox" <?= $isChecked ?> name="child_permissions[]" value="<?= $permission->name ?>">
			                                <?= $permission->description ?>
                                        </label>

		                                <?= Html::a(
		                                '<span class="glyphicon glyphicon-edit"></span>',
		                                ['/user/permission/view', 'id'=>$permission->name],
		                                ['target'=>'_blank']
	                                ) ?>
                                        <br/>
	                                <?php endforeach ?>
                                </fieldset>
                                <br/>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <hr/>

                    <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                        <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php endif; ?>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>