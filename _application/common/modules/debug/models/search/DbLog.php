<?php

namespace common\modules\debug\models\search;

use yii\debug\models\search\Base;
use common\models\Log;

class DbLog extends Base
{
    /**
     * @var string ip attribute input search value
     */
    public $level;
    /**
     * @var string method attribute input search value
     */
    public $category;
    /**
     * @var integer message attribute input search value
     */
    public $message;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'message', 'category'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level'     => 'Level',
            'category'  => 'Category',
            'message'   => 'Message',
        ];
    }

    /**
     * Returns data provider with filled models. Filter applied if needed.
     *
     * @param array $params an array of parameter values indexed by parameter names
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        $query = Log::find();
        $dataProvider = Log::getDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['level' => $this->level]);
        $query->andFilterWhere(['like', Log::tableName() . '.category', $this->category]);
        $query->andFilterWhere(['like', Log::tableName() . '.message',  $this->message]);

        return $dataProvider;
    }
}
