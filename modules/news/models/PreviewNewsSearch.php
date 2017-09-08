<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class PreviewNewsSearch extends News
{
    public $created_at_since;
    public $created_at_to;
    public $updated_at_since;
    public $updated_at_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_at_since',
                'created_at_to', 'updated_at_since', 'updated_at_to'], 'string'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = News::find();

        // add conditions that should always apply here

        $pageSize = (isset($params['per-page']) AND (int)$params['per-page']) ? abs((int)$params['per-page']) : 5;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['status'=>News::STATUS_ACTIVE]);

        // Поиск по датам
        $dateFields = ['created_at', 'updated_at', 'created_at_since', 'created_at_to', 'updated_at_since', 'updated_at_to'];
        $dateValues = [];
        foreach($dateFields as $dateField) {
            if ($this->$dateField) {
                $date = strtotime($this->$dateField);
                $dateValues[$dateField] = $date ? $date : null;
            } else {
                $dateValues[$dateField] = null;
            }
        }
        $query
            ->andFilterWhere([
                'created_at' => $dateValues['created_at'],
                'updated_at' => $dateValues['updated_at'],
            ])
            ->andFilterWhere(['>=', 'created_at',  $dateValues['created_at_since']])
            ->andFilterWhere(['<=', 'created_at', $dateValues['created_at_to']])
            ->andFilterWhere(['>=', 'updated_at', $dateValues['updated_at_since']])
            ->andFilterWhere(['<=', 'updated_at', $dateValues['updated_at_to']])
            ;

        return $dataProvider;
    }
}
