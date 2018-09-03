<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Day;

/**
 * DaySearch represents the model behind the search form of `frontend\models\Day`.
 */
class DaySearch extends Day
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tour_id'], 'integer'],
            [['title', 'title_ru', 'title_ko', 'itinerary', 'itinerary_ru', 'itinerary_ko', 'meals', 'meals_ru', 'meals_ko', 'accommodation', 'accommodation_ru', 'accommodation_ko'], 'safe'],
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
        $query = Day::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'tour_id' => $this->tour_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_ko', $this->title_ko])
            ->andFilterWhere(['like', 'itinerary', $this->itinerary])
            ->andFilterWhere(['like', 'itinerary_ru', $this->itinerary_ru])
            ->andFilterWhere(['like', 'itinerary_ko', $this->itinerary_ko])
            ->andFilterWhere(['like', 'meals', $this->meals])
            ->andFilterWhere(['like', 'meals_ru', $this->meals_ru])
            ->andFilterWhere(['like', 'meals_ko', $this->meals_ko])
            ->andFilterWhere(['like', 'accommodation', $this->accommodation])
            ->andFilterWhere(['like', 'accommodation_ru', $this->accommodation_ru])
            ->andFilterWhere(['like', 'accommodation_ko', $this->accommodation_ko]);

        return $dataProvider;
    }
}
