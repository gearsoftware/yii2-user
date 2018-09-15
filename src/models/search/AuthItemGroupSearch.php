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

use gearsoftware\models\AuthItemGroup;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthItemGroupSearch represents the model behind the search form about `gearsoftware\models\AuthItemGroup`.
 */
class AuthItemGroupSearch extends AuthItemGroup
{

    public function rules()
    {
        return [
            [['code', 'name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AuthItemGroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->created_at) {
            $tmp = explode(' - ', $this->created_at);
            if (isset($tmp[0], $tmp[1])) {
                $query->andFilterWhere(['between', Yii::$app->core->auth_item_group_table . '.created_at',
                    strtotime($tmp[0]), strtotime($tmp[1])]);
            }
        }

        $query->andFilterWhere(['like', Yii::$app->core->auth_item_group_table . '.code', $this->code])
            ->andFilterWhere(['like', Yii::$app->core->auth_item_group_table . '.name', $this->name]);

        return $dataProvider;
    }
}