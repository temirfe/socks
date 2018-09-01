<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tour;

/**
 * TourSearch represents the model behind the search form of `frontend\models\Tour`.
 */
class TourSearch extends Tour
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'days', 'category_id', 'destination_id'], 'integer'],
            [['title', 'title_ru', 'title_ko', 'image', 'description', 'description_ru', 'description_ko'], 'safe'],
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
        $query = Tour::find();

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
            'days' => $this->days,
            'category_id' => $this->category_id,
            'destination_id' => $this->destination_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_ko', $this->title_ko])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'description_ru', $this->description_ru])
            ->andFilterWhere(['like', 'description_ko', $this->description_ko]);

        return $dataProvider;
    }
}
