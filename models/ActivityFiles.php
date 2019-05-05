<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_files".
 *
 * @property int $activity_id
 * @property string $file_path
 *
 * @property ActivityBase $activity
 */
class ActivityFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'file_path'], 'required'],
            [['activity_id'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityBase::class, 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => Yii::t('app', 'Activity ID'),
            'file_path' => Yii::t('app', 'File Path'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(ActivityBase::class, ['id' => 'activity_id']);
    }
}
