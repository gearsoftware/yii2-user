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
use gearsoftware\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var gearsoftware\user\models\search\AuthItemGroupSearch $searchModel
 */
$this->title = Yii::t('core/user', 'Permission Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-ios-plus-outline"></i> '. Yii::t('core', 'Add New'), ['create'], ['class' => 'btn btn-primary btn-sm'])
];

echo GridView::widget([
	'id' => 'user-role-grid',
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
			'attribute' => 'name',
			'class' => 'gearsoftware\grid\columns\TitleActionColumn',
			'controller' => '/user/permission-groups',
			'title' => function ($model) {
				if (User::hasPermission('manageRolesAndPermissions')) {
					return Html::a(
						$model->name, ['update', 'id' => $model->code],
						['data-pjax' => 0]
					);
				} else {
					return $model->name;
				}

			},
			'buttonsTemplate' => '{update} {delete}',
		],
		'code',
		[
			'class' => 'gearsoftware\grid\columns\ActionColumn',
            'template' => '{update}{delete}',
			'dropdown' => true,
		],
		[
			'class' => 'gearsoftware\grid\columns\CheckboxColumn',
		],
	]
]);