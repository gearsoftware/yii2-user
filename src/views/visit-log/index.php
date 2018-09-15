<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\helpers\Html;
use gearsoftware\models\User;
use gearsoftware\grid\GridView;
use yii\helpers\ArrayHelper;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var gearsoftware\user\models\search\UserVisitLogSearch $searchModel
 */

$this->title = Yii::t('core/user', 'Visit Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'id' => 'user-visit-log-grid',
    'title' => $this->title,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkActions' => ' ',
    'columns' => [
        [
	        'class'=>'gearsoftware\grid\columns\SerialColumn'
        ],
        [
	        'attribute'=>'user_id',
	        'vAlign'=>'middle',
	        'width'=>'180px',
	        'value'=>function ($model, $key, $index, $widget) {
		        if (!empty($model->user->username)) {
			        return Html::a($model->user->username,
				        ['view', 'id' => $model->id], ['data-pjax' => 0]);
		        } else {
			        return null;
		        }
	        },
	        'filterType' => GridView::FILTER_SELECT2,
	        'filter'=>ArrayHelper::map(User::find()->orderBy('username')->asArray()->all(), 'username', 'username'),
	        'filterWidgetOptions'=>[
		        'pluginOptions'=>['allowClear' => true],
	        ],
	        'filterInputOptions' => [
		        'placeholder' => Yii::t('core', 'Select a {element}...',
			        ['element' => Yii::t('core/user', 'User')])
	        ],
	        'format'=>'raw'
        ],
        'language',
        'os',
        'browser',
        array(
	        'attribute' => 'ip',
	        'value' => function ($model) {
		        return Html::a($model->ip,
			        "http://ipinfo.io/" . $model->ip,
			        ["target" => "_blank"]);
	        },
	        'format' => 'raw',
        ),
        [
	        'attribute' => 'visit_time',
	        'value' => function ($model) {
		        return $model->visitDatetime;
	        },
	        'filterType' => 'gearsoftware\grid\DateRangePicker',
	        'filterWidgetOptions'=> [
		        'pluginOptions'=>[
			        //'timePicker' => true
		        ],
	        ],
	        'format'=>'raw',
	        'width'=>'250px',
        ],
        [
	        'class' => 'gearsoftware\grid\columns\ActionColumn',
	        'template' => '{view}'
        ],
        [
	        'class'=>'gearsoftware\grid\columns\CheckboxColumn',
        ],
    ]
]);