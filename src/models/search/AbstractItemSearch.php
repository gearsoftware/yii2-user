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

use gearsoftware\models\AbstractItem;
use gearsoftware\models\Permission;
use gearsoftware\models\Role;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

abstract class AbstractItemSearch extends AbstractItem
{

    public function rules()
    {
        return [
            [['name', 'description', 'group_code'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = (static::ITEM_TYPE == static::TYPE_ROLE) ? Role::find() : Permission::find();

        $query->joinWith(['group']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', Yii::$app->core->auth_item_table . '.name', $this->name])
            ->andFilterWhere(['like', Yii::$app->core->auth_item_table . '.description', $this->description])
            ->andFilterWhere([Yii::$app->core->auth_item_table . '.group_code' => $this->group_code]);

        return $dataProvider;
    }
}