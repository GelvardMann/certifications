<?php

namespace common\modules\user\models\profile;

use Yii;

/**
 * This is the model class for table "shops".
 *
 * @property int $id
 * @property string $name
 * @property string $city
 *
 * @property UsersProfile[] $usersProfiles
 */
class Shops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['city'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'city' => 'City',
        ];
    }

    /**
     * Gets query for [[UsersProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersProfiles()
    {
        return $this->hasMany(UsersProfile::className(), ['shop' => 'id']);
    }
}
