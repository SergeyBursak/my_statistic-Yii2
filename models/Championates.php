<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "championates".
 *
 * @property integer $id
 * @property string $name
 * @property integer $matches_all
 * @property integer $matches_succcess
 * @property double $percent_success
 */
class Championates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'championates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'matches_all', 'matches_succcess', 'percent_success'], 'required'],
            [['matches_all', 'matches_succcess'], 'integer'],
            [['percent_success'], 'number'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя Чемпионата',
            'matches_all' => 'Общее количество матчей',
            'matches_succcess' => 'Матчей Прошло',
            'percent_success' => 'Процент Проходимости',
        ];
    }

    public static function getAll(){
        $data = self::find()->all();
        return $data;
    }


    public static function getOne($id){
        $data = self::find()->where(['id' => $id])->one();
        return $data->percent_success;
    }
}
