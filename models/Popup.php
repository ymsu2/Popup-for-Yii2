<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "popup".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int|null $is_active
 * @property int|null $width
 * @property int|null $height
 * @property int|null $display_count
 * @property int|null $show_after
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Popup extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'popup';
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['is_active'], 'boolean'],
            [['width', 'height', 'show_after'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }


    /**
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['is_active', 'width', 'height', 'display_count', 'show_after'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }
     */

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'is_active' => 'Is Active',
            'width' => 'Width',
            'height' => 'Height',
            'display_count' => 'Display Count',
            'show_after' => 'Show After',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
