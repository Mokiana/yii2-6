<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class ActivitySearch extends Activity
{
    public function search($params){
        $model=new Activity();

//        print_r($model);exit;
        $query=$model::find();
        $query->with('user');

        $this->load($params);

        $provider=new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' =>[
                    'pageSize'=>5
                ],
                'sort'=>[
                    'defaultOrder'=>['startDate'=>SORT_DESC]
                ]
            ]
        );

        $query->andFilterWhere(['like','title',$this->title]);

        $query->andFilterWhere(['id'=>$this->id]);

        return $provider;
    }
}