<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\user\widgets\dashboard;

use gearsoftware\models\User;
use gearsoftware\user\models\search\UserSearch;
use gearsoftware\widgets\DashboardWidget;
use Yii;

class Users extends DashboardWidget
{
    /**
     * Most recent post limit
     */
    public $recentLimit = 5;

    /**
     * Post index action
     */
    public $indexAction = 'user/default/index';

    /**
     * Total count options
     *
     * @var array
     */
    public $options;

    public function run()
    {
        if (!$this->options) {
            $this->options = $this->getDefaultOptions();
        }

        if (User::hasPermission('viewUsers')) {

            $searchModel = new UserSearch();
            $formName = $searchModel->formName();

            $recent = User::find()->orderBy(['id' => SORT_DESC])->limit($this->recentLimit)->all();

            foreach ($this->options as &$option) {
                $count = User::find()->filterWhere($option['filterWhere'])->count();
                $option['count'] = $count;
                $option['url'] = [$this->indexAction, $formName => $option['filterWhere']];
            }

            return $this->render('users', [
                'height' => $this->height,
                'width' => $this->width,
                'position' => $this->position,
                'users' => $this->options,
                'recent' => $recent,
            ]);

        }
    }

    public function getDefaultOptions()
    {
        return [
	        ['label' => Yii::t('core', 'All'), 'icon' => 'ok', 'filterWhere' => []],
            ['label' => Yii::t('core', 'Active'), 'icon' => 'ok', 'filterWhere' => ['status' => User::STATUS_ACTIVE]],
            ['label' => Yii::t('core', 'Inactive'), 'icon' => 'ok', 'filterWhere' => ['status' => User::STATUS_INACTIVE]],
            ['label' => Yii::t('core', 'Banned'), 'icon' => 'ok', 'filterWhere' => ['status' => User::STATUS_BANNED]],
        ];
    }
}