<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\grid\GridPageSize;
use gearsoftware\grid\GridView;
use gearsoftware\helpers\Html;
use gearsoftware\models\AuthItemGroup;
use gearsoftware\models\Permission;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var gearsoftware\user\models\search\PermissionSearch $searchModel
 * @var yii\web\View $this
 */

$this->title = Yii::t('core/user', 'Permissions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-ios-plus-outline"></i> '. Yii::t('core', 'Add New'), ['create'], ['class' => 'btn btn-primary btn-sm']),
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/user', 'Permission Groups'), ['/user/permission-groups'], ['class' => 'btn btn-success btn-sm']),
];

echo GridView::widget([
	'id' => 'user-permission-grid',
	'title' => $this->title,
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'bulkActionOptions' => [
		'actions' => [
			Url::to(['bulk-delete']) => Yii::t('core', 'Delete'),
		]
	],
	'columns' => [
		[
			'class' => 'gearsoftware\grid\columns\SerialColumn'
		],
		[
			'attribute' => 'description',
			'class' => 'gearsoftware\grid\columns\TitleActionColumn',
			'controller' => '/user/permission',
			'title' => function ($model) {
				return Html::a(
					$model->description,
					['view', 'id' => $model->name],
					(($model->name == Yii::$app->core->commonPermissionName)) ? ['data-pjax' => 0, 'class' => 'label label-primary'] : ['data-pjax' => 0]
				);
			},
			'buttons' => [
				'view' => function ($url, $model, $key) {
					$options = array_merge([
						'title' => Yii::t('core', 'Settings'),
						'aria-label' => Yii::t('core', 'Settings'),
						'data-pjax' => '0',
					]);
					return Html::a(Yii::t('core', 'Settings'), $url, $options);
				}
			],

		],
		'name',
		[
			'attribute' => 'group_code',
			'filter' => ArrayHelper::map(AuthItemGroup::find()->asArray()->all(),
				'code', 'name'),
			'value' => function (Permission $model) {
				return $model->group_code ? $model->group->name : '';
			},
		],
		[
			'class' => 'gearsoftware\grid\columns\ActionColumn',
			'dropdown' => true,
		],
		[
			'class' => 'gearsoftware\grid\columns\CheckboxColumn',
		],
	]
]);