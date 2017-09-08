<?php

namespace app\modules\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\users\models\UserModel as User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    public $created_at_since;
    public $created_at_to;
    public $updated_at_since;
    public $updated_at_to;
    public $auth_at_since;
    public $auth_at_to;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['role', 'username', 'email', 'full_name'], 'string'],
            [['created_at', 'updated_at', 'auth_at', 'created_at_since', 'created_at_to', 
                'updated_at_since', 'updated_at_to', 'auth_at_since', 'auth_at_to'], 'string'],
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
        $query = User::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'full_name', $this->full_name]);

        // Поиск по датам
        $dateFields = ['created_at', 'updated_at', 'auth_at', 'created_at_since', 'created_at_to', 'updated_at_since',
            'updated_at_to', 'auth_at_since', 'auth_at_to'];
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
                'auth_at' => $dateValues['auth_at'],
            ])
            ->andFilterWhere(['>=', 'created_at',  $dateValues['created_at_since']])
            ->andFilterWhere(['<=', 'created_at', $dateValues['created_at_to']])
            ->andFilterWhere(['>=', 'updated_at', $dateValues['updated_at_since']])
            ->andFilterWhere(['<=', 'updated_at', $dateValues['updated_at_to']])
            ->andFilterWhere(['>=', 'auth_at', $dateValues['auth_at_since']])
            ->andFilterWhere(['<=', 'auth_at', $dateValues['auth_at_to']])
            ;

        // Поиск по роли http://www.yiiframework.com/forum/index.php/topic/72484-yii2-user-grid-filter-by-role/
        if($this->role){
              $query
                ->leftJoin('auth_assignment','auth_assignment.user_id = id')
                ->andFilterWhere(['auth_assignment.item_name' => $this->role]);
         }

        return $dataProvider;
    }
}
