<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Package;

/**
 * PackageSearch represents the model behind the search form of `frontend\models\Package`.
 */
class PackageSearch extends Package
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tour_id'], 'integer'],
            [['included', 'included_ru', 'included_ko', 'not_included', 'not_included_ru', 'not_included_ko'], 'safe'],
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
        $query = Package::find();

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

        $query->andFilterWhere(['like', 'included', $this->included])
            ->andFilterWhere(['like', 'included_ru', $this->included_ru])
            ->andFilterWhere(['like', 'included_ko', $this->included_ko])
            ->andFilterWhere(['like', 'not_included', $this->not_included])
            ->andFilterWhere(['like', 'not_included_ru', $this->not_included_ru])
            ->andFilterWhere(['like', 'not_included_ko', $this->not_included_ko]);

        return $dataProvider;
    }
}
