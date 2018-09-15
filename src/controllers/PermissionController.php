<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\user\controllers;

use gearsoftware\controllers\BaseController;
use gearsoftware\helpers\AuthHelper;
use gearsoftware\models\AbstractItem;
use gearsoftware\models\Permission;
use gearsoftware\models\Route;
use gearsoftware\user\models\search\PermissionSearch;
use Yii;

class PermissionController extends BaseController
{
    /**
     * @var Permission
     */
    public $modelClass = 'gearsoftware\models\Permission';

    /**
     * @var PermissionSearch
     */
    public $modelSearchClass = 'gearsoftware\user\models\search\PermissionSearch';

    /**
     * @param string $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $item = $this->findModel($id);

        $routes = Route::find()->asArray()->all();

        $permissions = Permission::find()
            ->andWhere(['not in', Yii::$app->core->auth_item_table . '.name',
                [Yii::$app->core->commonPermissionName, $id]])
            ->joinWith('group')
            ->all();

        $permissionsByGroup = [];
        foreach ($permissions as $permission) {
            $permissionsByGroup[@$permission->group->name][] = $permission;
        }

        $childRoutes = AuthHelper::getChildrenByType($item->name, AbstractItem::TYPE_ROUTE);
        $childPermissions = AuthHelper::getChildrenByType($item->name, AbstractItem::TYPE_PERMISSION);

        return $this->renderIsAjax('view', compact('item', 'childPermissions', 'routes', 'permissionsByGroup', 'childRoutes'));
    }

    /**
     * Add or remove child permissions (including routes) and return back to view
     *
     * @param string $id
     *
     * @return string|\yii\web\Response
     */
    public function actionSetChildPermissions($id)
    {
        $item = $this->findModel($id);

        $newChildPermissions = Yii::$app->request->post('child_permissions', []);

        $oldChildPermissions = array_keys(AuthHelper::getChildrenByType($item->name,
            AbstractItem::TYPE_PERMISSION));

        $toRemove = array_diff($oldChildPermissions, $newChildPermissions);
        $toAdd = array_diff($newChildPermissions, $oldChildPermissions);

        Permission::addChildren($item->name, $toAdd);
        Permission::removeChildren($item->name, $toRemove);

        Yii::$app->session->setFlash('mint', Yii::t('core', 'The changes have been saved.'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add or remove routes for this permission
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetChildRoutes($id)
    {
        $item = $this->findModel($id);

        $newRoutes = Yii::$app->request->post('child_routes', []);

        $oldRoutes = array_keys(AuthHelper::getChildrenByType($item->name,
            AbstractItem::TYPE_ROUTE));

        $toAdd = array_diff($newRoutes, $oldRoutes);
        $toRemove = array_diff($oldRoutes, $newRoutes);

        Permission::addChildren($id, $toAdd);
        Permission::removeChildren($id, $toRemove);

        if (($toAdd OR $toRemove) AND ($id == Yii::$app->core->commonPermissionName)) {
            Yii::$app->cache->delete('__commonRoutes');
        }

        AuthHelper::invalidatePermissions();

        Yii::$app->session->setFlash('mint', Yii::t('core', 'The changes have been saved.'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add new routes and remove unused (for example if module or controller was deleted)
     *
     * @param string $id
     * @param null   $deleteUnused
     *
     * @return \yii\web\Response
     */
    public function actionRefreshRoutes($id, $deleteUnused = null)
    {
        Route::refreshRoutes($deleteUnused !== null);

        return $this->redirect(['view', 'id'=>$id]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Permission();
        $model->scenario = 'webInput';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'webInput';

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('update', compact('model'));
    }
}