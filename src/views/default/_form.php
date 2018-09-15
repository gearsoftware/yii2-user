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
use gearsoftware\widgets\ActiveForm;
use gearsoftware\helpers\CoreHelper;

/**
 * @var yii\web\View $this
 * @var gearsoftware\models\User $model
 * @var gearsoftware\widgets\ActiveForm $form
 */
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'user',
        'validateOnBlur' => false,
    ]);
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

                    <?php if ($model->isNewRecord): ?>
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                        <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                    <?php endif; ?>
                    
                    <?php if (User::hasPermission('editUserEmail')): ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => 124]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => 124]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'gender')->dropDownList(User::getGenderList()) ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'birth_day')->textInput(['maxlength' => 2]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'birth_month')->dropDownList(CoreHelper::getMonthsList(false)) ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'birth_year')->textInput(['maxlength' => 4]) ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'info')->textarea(['maxlength' => 255]) ?>
             
                </div>
            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= $form->field($model->loadDefaultValues(), 'status')->dropDownList(User::getStatusList()) ?>

                        <?php if (User::hasPermission('editUserEmail')): ?>
                            <?= $form->field($model, 'email_confirmed')->checkbox() ?>
                        <?php endif; ?>
                        
                        <?= $form->field($model, 'skype')->textInput(['maxlength' => 64]) ?>
                        
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => 24]) ?>

                        <?php if (User::hasPermission('bindUserToIp')): ?>
                            <?= $form->field($model, 'bind_to_ip')->textInput(['maxlength' => 255])->hint(Yii::t('core', 'For example') . ' : 123.34.56.78, 234.123.89.78') ?>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['registration_ip'] ?> :
                            </label>
                            <span><?= $model->registration_ip ?></span>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['created_at'] ?> :
                            </label>
                            <span><?= "{$model->createdDate} {$model->createdTime}" ?></span>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['updated_at'] ?> :
                            </label>
                            <span><?= $model->updatedDatetime ?></span>
                        </div>

                        <div class="form-group ">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('core', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('core', 'Cancel'), ['/user/default/index'], ['class' => 'btn btn-default']) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('core', 'Delete'), ['/user/default/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ])
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>











