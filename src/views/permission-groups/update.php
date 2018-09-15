<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var gearsoftware\models\AuthItemGroup $model
 */

$this->title = Yii::t('core/user', 'Update Permission Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/user', 'Permission Groups'), 'url' => ['/user/permission-groups/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permission-groups-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
