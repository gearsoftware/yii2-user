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
 * @var $this yii\web\View
 * @var gearsoftware\widgets\ActiveForm $form
 * @var array $routes
 * @var array $childRoutes
 * @var array $permissionsByGroup
 * @var array $childPermissions
 * @var yii\rbac\Permission $item
 */

use gearsoftware\helpers\Html;
use gearsoftware\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('core/user', '{permission} Permission Settings', ['permission' => $item->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Permissions'), 'url' => ['/user/role/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('core', 'Edit'), ['update', 'id' => $item->name], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('core', 'Create'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <?= Yii::t('core/user', 'Child permissions') ?>
                    </strong>
                </div>
                <div class="panel-body">

                    <?= Html::beginForm(['set-child-permissions', 'id' => $item->name]) ?>

                    <div class="row">
	                    <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

				                    <?php foreach ($permissions as $permission): ?>
                                        <label>
						                    <?php $isChecked = in_array($permission->name, ArrayHelper::map($childPermissions, 'name', 'name')) ? 'checked' : '' ?>
                                            <input type="checkbox" <?= $isChecked ?> name="child_permissions[]" value="<?= $permission->name ?>">
						                    <?= $permission->description ?>
                                        </label>

					                    <?= Html::a(
					                    '<span class="glyphicon glyphicon-edit"></span>',
					                    ['view', 'id'=>$permission->name],
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

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span><?= Yii::t('core/user', 'Routes') ?>
	                    <?= Html::a(
		                    Yii::t('core/user', 'Refresh routes (and delete unused)'),
		                    ['refresh-routes', 'id'=>$item->name, 'deleteUnused'=>1],
		                    [
			                    'class' => 'btn btn-default btn-sm pull-right',
			                    'style'=>'margin-top:-5px; text-transform:none;',
			                    //'data-confirm'=>Yii::t('core/user', 'Routes that are not exists in this application will be deleted. Do not recommended for application with "advanced" structure, because frontend and backend have they own set of routes.'),
			                    'disabled' => 'disabled',
			                    'onclick' => "return false;",
		                    ]
	                    ) ?>

	                    <?= Html::a(
		                    Yii::t('core/user', 'Refresh routes'),
		                    ['refresh-routes', 'id'=>$item->name],
		                    [
			                    'class' => 'btn btn-default btn-sm pull-right',
			                    'style'=>'margin-top:-5px; text-transform:none;',
			                    'disabled' => 'disabled',
			                    'onclick' => "return false;",
		                    ]
	                    ) ?>
                    </strong>
                </div>

                <div class="panel-body">

                    <?= Html::beginForm(['set-child-routes', 'id' => $item->name]) ?>

                    <div class="row">
                        <div class="col-sm-2">
                            <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                                <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                            <?php endif; ?>
                        </div>

                        <div class="col-sm-6">
                            <input id="search-in-routes" autofocus="on" type="text" class="form-control input-sm"
                                   placeholder="<?= Yii::t('core/user', 'Search route') ?>">
                        </div>

                        <div class="col-sm-4 text-right">
                            <span id="show-only-selected-routes" class="btn btn-default btn-sm">
                                <i class="fa fa-minus"></i> <?= Yii::t('core/user', 'Show only selected') ?>
                            </span>
                            <span id="show-all-routes" class="btn btn-default btn-sm hide">
                                <i class="fa fa-plus"></i> <?= Yii::t('core/user', 'Show all elements') ?>
                            </span>
                        </div>
                        <!--div class="col-sm-3 text-right">
                            <span id="show-only-selected-routes" class="btn btn-default btn-sm">
				<i class="fa fa-minus"></i> <?= Yii::t('core/user', 'Show only selected') ?>
                            </span>
                            <span id="show-all-routes" class="btn btn-default btn-sm hide">
				<i class="fa fa-plus"></i> <?= Yii::t('core/user', 'Show all') ?>
                            </span>
                        </div-->
                    </div>

                    <hr/>

                    <?= Html::checkboxList(
                        'child_routes',
                        ArrayHelper::map($childRoutes, 'name', 'name'),
                        ArrayHelper::map($routes, 'name', 'name'),
                        [
                            'id' => 'routes-list',
                            'separator' => '<div class="separator"></div>',
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return Html::checkbox($name, $checked, [
                                    'value' => $value,
                                    'label' => '<span class="route-text">' . $label . '</span>',
                                    'labelOptions' => ['class' => 'route-label'],
                                    'class' => 'route-checkbox',
                                ]);
                            },
                        ]
                    ) ?>

                    <hr/>
                    <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                        <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php endif; ?>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS

var routeCheckboxes = $('.route-checkbox');
var routeText = $('.route-text');

// For checked routes
var backgroundColor = '#D6FFDE';

function showAllRoutesBack() {
	$('#routes-list').find('.hide').each(function(){
		$(this).removeClass('hide');
	});
}

//Make tree-like structure by padding controllers and actions
routeText.each(function(){
	var _t = $(this);

	var chunks = _t.html().split('/').reverse();
	var margin = chunks.length * 30 - 30;

	if ( chunks[0] == '*' )
	{
		margin -= 30;
	}

	_t.closest('label').closest('div.checkbox').css('margin-left', margin);

});

// Highlight selected checkboxes
routeCheckboxes.each(function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('div').css('background', backgroundColor);
	}
});

// Change background on check/uncheck
routeCheckboxes.on('change', function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('div').css('background', backgroundColor);
	}
	else
	{
		_t.closest('div').css('background', 'none');
	}
});


// Hide on not selected routes
$('#show-only-selected-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-all-routes').removeClass('hide');

	routeCheckboxes.each(function(){
		var _t = $(this);

		if ( ! _t.is(':checked') )
		{
			_t.closest('div').addClass('hide');
		}
	});
});

// Show all routes back
$('#show-all-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-only-selected-routes').removeClass('hide');

	showAllRoutesBack();
});

// Search in routes and hide not matched
$('#search-in-routes').on('change keyup', function(){
	var input = $(this);

	if ( input.val() == '' )
	{
		showAllRoutesBack();
		return;
	}

	routeText.each(function(){
		var _t = $(this);

		if ( _t.html().indexOf(input.val()) > -1 )
		{
			_t.closest('div').removeClass('hide');
		}
		else
		{
			_t.closest('div').addClass('hide');
		}
	});
});

JS;

$this->registerJs($js);
?>