<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\user\models\search;

use gearsoftware\models\User;
use gearsoftware\models\UserVisitLog;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserVisitLogSearch represents the model behind the search form about `gearsoftware\models\UserVisitLog`.
 */
class UserVisitLogSearch extends UserVisitLog
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['token', 'ip', 'language', 'user_id', 'os', 'browser', 'visit_time'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserVisitLog::find();

        $query->joinWith(['user']);

        // Don't let non-superadmin view superadmin activity
        if (!Yii::$app->user->isSuperadmin) {
            $query->andWhere([User::tableName() . '.superadmin' => 0]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->visit_time) {
            $tmp = explode(' - ', $this->visit_time);
            if (isset($tmp[0], $tmp[1])) {
                $query->andFilterWhere(['between', static::tableName() . '.visit_time',
                    strtotime($tmp[0]), strtotime($tmp[1])]);
            }
        }

        $query->andFilterWhere([
            $this->tableName() . '.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', User::tableName() . '.username', $this->user_id])
            ->andFilterWhere(['like', static::tableName() . '.ip', $this->ip])
            ->andFilterWhere(['like', static::tableName() . '.os', $this->os])
            ->andFilterWhere(['like', static::tableName() . '.browser', $this->browser])
            ->andFilterWhere(['like', static::tableName() . '.language', $this->language]);

        return $dataProvider;
    }
}