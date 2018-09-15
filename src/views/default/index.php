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
use gearsoftware\grid\GridQuickLinks;
use gearsoftware\grid\GridView;
use gearsoftware\helpers\Html;
use gearsoftware\models\Role;
use gearsoftware\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var gearsoftware\user\models\search\UserSearch $searchModel
 */
$this->title = Yii::t('core/user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
	Html::a('<i class="ion-ios-plus-outline"></i> '. Yii::t('core', 'Add New'), ['create'], ['class' => 'btn btn-primary btn-sm']),
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/user', 'Roles'), ['/user/role'], ['class' => 'btn btn-success btn-sm']),
	Html::a('<i class="ion-navicon-round"></i> '. Yii::t('core/user', 'Permissions'), ['/user/permission'], ['class' => 'btn btn-success btn-sm']),
];

echo GridView::widget([
	'id' => 'user-grid',
	'model' =>  User::className(),
	'title' => $this->title,
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'bulkActionOptions' => [
		'gridId' => 'user-grid',
	],
	'quickLinksOptions' => [
		['label' => Yii::t('core', 'All'), 'filterWhere' => []],
		['label' => Yii::t('core', 'Active'), 'filterWhere' => ['status' => User::STATUS_ACTIVE]],
		['label' => Yii::t('core', 'Inactive'), 'filterWhere' => ['status' => User::STATUS_INACTIVE]],
		['label' => Yii::t('core', 'Banned'), 'filterWhere' => ['status' => User::STATUS_BANNED]],
	],
	'columns' => [
		[
			'class'=>'gearsoftware\grid\columns\SerialColumn'
		],
		[
			'attribute' => 'username',
			'vAlign'=>'middle',
			'width'=>'180px',
			'value'=>function ($model, $key, $index, $widget) {
				if (User::hasPermission('editUsers')) {
					return Html::a($model->username, ['/user/default/update', 'id' => $model->id], ['data-pjax' => 0]);
				} else {
					return $model->username;
				}
			},
			'filterType' => GridView::FILTER_SELECT2,
			'filter' => ArrayHelper::map(User::find()->orderBy('username')->asArray()->all(), 'username', 'username'),
			'filterWidgetOptions'=>[
				'pluginOptions'=>['allowClear' => true],
			],
			'filterInputOptions' => [
				'placeholder' => Yii::t('core', 'Select a {element}...',
					['element' => Yii::t('core/user', 'User')]),
			],
			'format'=>'raw'
		],
		[
			'attribute' => 'email',
			'filterType' => GridView::FILTER_SELECT2,
			'filter' => ArrayHelper::map(User::find()->orderBy('username')->asArray()->all(), 'email', 'email'),
			'filterWidgetOptions'=>[
				'pluginOptions'=>['allowClear' => true],
			],
			'filterInputOptions' => [
				'placeholder' => Yii::t('core', 'Select a {element}...',
					['element' => Yii::t('core', 'E-mail')])
			],
			'visible' => User::hasPermission('viewUserEmail'),
			'format'=>'raw'
		],
		[
			'attribute' => 'gridRoleSearch',
			'value' => function (User $model) {
				return implode(', ',
					ArrayHelper::map($model->roles, 'name',
						'description'));
			},
			'filterType' => GridView::FILTER_SELECT2,
			'filter' => ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),'name', 'description'),
			'filterWidgetOptions'=>[
				'pluginOptions'=>['allowClear' => true],
			],
			'filterInputOptions' => [
				'placeholder' => Yii::t('core', 'Select a {element}...',
					['element' => Yii::t('core', 'Rol')])
			],
			'visible' => User::hasPermission('viewUserRoles'),
			'format'=>'raw'
		],
		[
			'class' => 'gearsoftware\grid\columns\StatusColumn',
			'attribute' => 'superadmin',
			'visible' => Yii::$app->user->isSuperadmin,
			'options' => ['style' => 'width:60px']
		],
		[
			'class' => 'gearsoftware\grid\columns\ActionColumn',
			'dropdown' => true,
		],
		[
			'class'=>'gearsoftware\grid\columns\CheckboxColumn',
		],
	]
]);
?>

<?php /* GridView::widget([
    'id' => 'user-grid',
    'model' =>  User::className(),
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkActionOptions' => [
        'gridId' => 'user-grid',
    ],
    'quickLinksOptions' => [
        ['label' => Yii::t('core', 'All'), 'filterWhere' => []],
        ['label' => Yii::t('core', 'Active'), 'filterWhere' => ['status' => User::STATUS_ACTIVE]],
        ['label' => Yii::t('core', 'Inactive'), 'filterWhere' => ['status' => User::STATUS_INACTIVE]],
        ['label' => Yii::t('core', 'Banned'), 'filterWhere' => ['status' => User::STATUS_BANNED]],
    ],
    'columns' => [
        ['class' => 'gearsoftware\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
        [
            'attribute' => 'username',
            'controller' => '/user/default',
            'class' => 'gearsoftware\grid\columns\TitleActionColumn',
            'title' => function (User $model) {
                if (User::hasPermission('editUsers')) {
                    return Html::a($model->username, ['/user/default/update', 'id' => $model->id], ['data-pjax' => 0]);
                } else {
                    return $model->username;
                }
            },
            'buttonsTemplate' => '{update} {delete} {permissions} {password}',
            'buttons' => [
                'permissions' => function ($url, $model, $key) {
                    return Html::a(Yii::t('core/user', 'Permissions'),
                        Url::to(['user-permission/set', 'id' => $model->id]), [
                            'title' => Yii::t('core/user', 'Permissions'),
                            'data-pjax' => '0'
                        ]
                    );
                },
                'password' => function ($url, $model, $key) {
                    return Html::a(Yii::t('core/user', 'Password'),
                        Url::to(['default/change-password', 'id' => $model->id]), [
                            'title' => Yii::t('core/user', 'Password'),
                            'data-pjax' => '0'
                        ]
                    );
                }
            ],
            'options' => ['style' => 'width:300px']
        ],
        [
            'attribute' => 'email',
            'format' => 'raw',
            'visible' => User::hasPermission('viewUserEmail'),
        ],
        [
            'attribute' => 'gridRoleSearch',
            'filter' => ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),
                'name', 'description'),
            'value' => function (User $model) {
                return implode(', ',
                    ArrayHelper::map($model->roles, 'name',
                        'description'));
            },
            'format' => 'raw',
            'visible' => User::hasPermission('viewUserRoles'),
        ],
        [
            'class' => 'gearsoftware\grid\columns\StatusColumn',
            'attribute' => 'superadmin',
            'visible' => Yii::$app->user->isSuperadmin,
            'options' => ['style' => 'width:60px']
        ],
        [
            'class' => 'gearsoftware\grid\columns\StatusColumn',
            'attribute' => 'status',
            'optionsArray' => [
                [User::STATUS_ACTIVE, Yii::t('core', 'Active'), 'primary'],
                [User::STATUS_INACTIVE, Yii::t('core', 'Inactive'), 'info'],
                [User::STATUS_BANNED, Yii::t('core', 'Banned'), 'default'],
            ],
            'options' => ['style' => 'width:60px']
        ],
    ],
]);
*/
?>
