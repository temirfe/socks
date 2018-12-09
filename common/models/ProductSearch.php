<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Product;
use frontend\models\Category;

/**
 * ProductSearch represents the model behind the search form of `frontend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'public', 'category_id', 'price', 'sex'], 'integer'],
            [['images', 'title', 'description'], 'safe'],
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
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 24],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
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
            'public' => $this->public,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'sex' => $this->sex,
        ]);
        if(!empty($params['show'])){
            $ctg='';
            switch($params['show']){
                case "socks":$ctg=1;break;
                case "singlets":$ctg=2;break;
                case "underwear":$ctg=3;break;
            }
            $query->andFilterWhere(['category_id' => $ctg]);
        }
        if(!empty($params['category_id'])){
            $withChildren=Category::withChildren($params['category_id']);
            $query->where(['category_id'=>$withChildren]);
        }

        $query->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
