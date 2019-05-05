<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activities".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $startDate
 * @property string $endDate
 * @property string $email
 * @property int $isBlocking
 * @property int $needNotification
 * @property string $date_created
 *
 * @property ActivityFiles[] $activityFiles
 */
class ActivityBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'startDate'], 'required'],
            [['user_id', 'isBlocking', 'needNotification'], 'integer'],
            [['description'], 'string'],
            [['startDate', 'endDate', 'date_created'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'startDate' => Yii::t('app', 'Start Date'),
            'endDate' => Yii::t('app', 'End Date'),
            'email' => Yii::t('app', 'Email'),
            'isBlocking' => Yii::t('app', 'Is Blocking'),
            'needNotification' => Yii::t('app', 'Need Notification'),
            'date_created' => Yii::t('app', 'Date Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityFiles()
    {
        return $this->hasMany(ActivityFiles::class, ['activity_id' => 'id']);
    }
}
