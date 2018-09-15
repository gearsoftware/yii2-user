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
use gearsoftware\models\AuthItemGroup;
use gearsoftware\user\models\search\AuthItemGroupSearch;

/**
 * AuthItemGroupController implements the CRUD actions for AuthItemGroup model.
 */
class PermissionGroupsController extends BaseController
{
    /**
     * @var AuthItemGroup
     */
    public $modelClass = 'gearsoftware\models\AuthItemGroup';

    /**
     * @var AuthItemGroupSearch
     */
    public $modelSearchClass = 'gearsoftware\user\models\search\AuthItemGroupSearch';

    public $disabledActions = ['view'];

    /**
     * Define redirect page after update, create, delete, etc
     *
     * @param string $action
     * @param AuthItemGroup $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'create':
                return ['update', 'id' => $model->code];
                break;
            default:
                return ['index'];
        }
    }
}