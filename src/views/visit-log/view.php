<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var gearsoftware\models\UserVisitLog $model
 */

$this->title = Yii::t('core/user', 'Log №{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Visit Log'), 'url' => ['/user/visit-log/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-visit-log-view">

    <h3 class="lte-hide-title"><?= $this->title ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'user_id',
                        'value' => @$model->user->username,
                    ],
                    [
                        'attribute' => 'visit_time',
                        'value' => $model->visitDatetime,
                    ],
                    'ip',
                    'language',
                    'os',
                    'browser',
                    'user_agent',
                ],
            ]) ?>

        </div>
    </div>
</div>
