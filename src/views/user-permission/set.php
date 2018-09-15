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
 * @var yii\web\View $this
 * @var array $permissionsByGroup
 * @var gearsoftware\models\User $user
 */

use gearsoftware\models\Role;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use gearsoftware\helpers\Html;

$this->title = Yii::t('core/user', 'Roles and Permissions for "{user}"', ['user' => $user->username]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', $user->username), 'url' => ['/user/default/update', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;

BootstrapPluginAsset::register($this);
?>
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span> <?= Yii::t('core/user', 'Roles') ?>
                    </strong>
                </div>
                <div class="panel-body">

                    <?= Html::beginForm(['set-roles', 'id' => $user->id]) ?>

	                <?php foreach (Role::getAvailableRoles() as $aRole): ?>
                        <label>
			                <?php $isChecked = in_array($aRole['name'], ArrayHelper::map(Role::getUserRoles($user->id), 'name', 'name')) ? 'checked' : '' ?>
                            <input type="checkbox" <?= $isChecked ?> name="roles[]" value="<?= $aRole['name'] ?>">
			                <?= $aRole['description'] ?>
                        </label>

		                <?= Html::a(
		                '<span class="glyphicon glyphicon-edit"></span>',
		                ['/user/role/view', 'id'=>$aRole['name']],
		                ['target'=>'_blank']
	                ) ?>
                        <br/>
	                <?php endforeach ?>
                    <br/>

                    <?php if (Yii::$app->user->isSuperadmin OR Yii::$app->user->id != $user->id): ?>

                        <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php else: ?>
                        <div class="alert alert-warning well-sm text-center">
                            <?= Yii::t('core/user', "You can't update own permissions!") ?>
                        </div>
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
                    <div class="row">
	                    <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>
                                    <ul style="list-style-type: none">
					                    <?php foreach ($permissions as $permission): ?>
                                            <li>
							                    <?= $permission->description ?>

							                    <?= Html::a(
								                    '<span class="glyphicon glyphicon-edit"></span>',
								                    ['/user/permission/view', 'id'=>$permission->name],
								                    ['target'=>'_blank']
							                    ) ?>
                                            </li>
					                    <?php endforeach ?>
                                    </ul>
                                </fieldset>
                                <br/>
                            </div>
	                    <?php endforeach ?>

                    </div>
                </div>
            </div>
        </div>
    </div>