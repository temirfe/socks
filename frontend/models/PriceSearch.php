<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Price;

/**
 * PriceSearch represents the model behind the search form of `frontend\models\Price`.
 */
class PriceSearch extends Price
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'tour_id', 'group_of'], 'integer'],
            [['title', 'title_ru', 'title_ko', 'note', 'note_ru', 'note_ko', 'date_start', 'date_end', 'currency'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Price::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'price' => $this->price,
            'tour_id' => $this->tour_id,
            'group_of' => $this->group_of,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_ko', $this->title_ko])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'note_ru', $this->note_ru])
            ->andFilterWhere(['like', 'note_ko', $this->note_ko])
            ->andFilterWhere(['like', 'currency', $this->currency]);

        return $dataProvider;
    }
}
