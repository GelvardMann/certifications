<?php

namespace common\modules\user\models\profile;

use Yii;

/**
 * This is the model class for table "department_list".
 *
 * @property int $id
 * @property string $name
 * @property int $author_id
 *
 * @property CertificationsList[] $certificationsLists
 * @property User $author
 */
class DepartmentList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
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
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[CertificationsLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificationsLists()
    {
        return $this->hasMany(CertificationsList::className(), ['department_id' => 'id']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
