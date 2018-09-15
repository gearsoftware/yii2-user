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

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class VisitLogController extends BaseController
{
    /**
     *
     * @inheritdoc
     */
    public $modelClass = 'gearsoftware\models\UserVisitLog';

    /**
     *
     * @inheritdoc
     */
    public $modelSearchClass = 'gearsoftware\user\models\search\UserVisitLogSearch';

    /**
     *
     * @inheritdoc
     */
    public $enableOnlyActions = ['index', 'view', 'grid-page-size'];

}