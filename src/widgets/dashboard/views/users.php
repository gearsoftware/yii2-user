<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\assets\core\CoreAsset;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */

CoreAsset::register($this);
?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-control">
            <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn" aria-expanded="false"> <?= Yii::t('core', 'Options') ?>
                    <i class="caret"> </i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
	                <?php foreach ($users as $item) : ?>
                        <li><a href="<?=  Url::to($item['url']); ?>"><?= $item['label'] . ' ('. $item['count'] . ')'; ?></a></li>
	                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <h3 class="panel-title"><?= Yii::t('core', 'Registered Users') ?></h3>
    </div>
    <div class="list-group bg-trans">
        <?php if (count($recent)): ?>
            <?php foreach ($recent as $item) : ?>
                <a href="<?= Url::to(['/user/default/update', 'id' => $item->id]) ?>" class="list-group-item">
                    <div class="media-left pos-rel">
                        <img class="img-circle img-xs" src="<?= $item->getAvatar('large'); ?>" alt="Profile Picture">
                        <i class="badge badge-success badge-stat badge-icon pull-left"></i>
                    </div>
                    <div class="media-body">
                        <p class="mar-no"><?= $item->fullname ?></p>
                        <small class="text-muted"><?= implode(', ', ArrayHelper::map($item->roles, 'name', 'description')); ?></small>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <em><?= Yii::t('core/user', 'No users found.') ?></em>
        <?php endif; ?>
    </div>
</div>