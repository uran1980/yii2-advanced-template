<?php
namespace frontend\modules\site\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use frontend\modules\site\Module;
use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property integer $status
 * @property integer $category
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Article extends ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;

    const CATEGORY_ECONOMY = 1;
    const CATEGORY_SOCIETY = 2;
    const CATEGORY_SPORT = 3;

    /**
     * Declares the name of the database table associated with this AR class.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'summary', 'content', 'status'], 'required'],
            [['user_id', 'status', 'category'], 'integer'],
            [['summary', 'content'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'            => Module::t('ID'),
            'user_id'       => Module::t('Author'),
            'title'         => Module::t('Title'),
            'summary'       => Module::t('Summary'),
            'content'       => Module::t('Content'),
            'status'        => Module::t('Status'),
            'category'      => Module::t('Category'),
            'created_at'    => Module::t('Created At'),
            'updated_at'    => Module::t('Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets the id of the article creator.
     * NOTE: needed for RBAC Author rule.
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->user_id;
    }

    /**
     * Gets the author name from the related User table.
     *
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->user->username;
    }

    /**
     * Returns the article status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status ;

        if ($status === self::STATUS_DRAFT) {
            return Module::t('Draft');
        }
        else {
            return Module::t('Published');
        }
    }

    /**
     * Returns the array of possible article status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_DRAFT     => Module::t('Draft'),
            self::STATUS_PUBLISHED => Module::t('Published'),
        ];

        return $statusArray;
    }

    /**
     * Returns the article category in nice format.
     *
     * @param  null|integer $category Category integer value if sent to method.
     * @return string                 Nicely formatted category.
     */
    public function getCategoryName($category = null)
    {
        $category = (empty($category)) ? $this->category : $category ;

        if ($category === self::CATEGORY_ECONOMY) {
            return Module::t('Economy');
        }
        elseif ($category === self::CATEGORY_SOCIETY) {
            return Module::t('Society');
        }
        else {
            return Module::t('Sport');
        }
    }

    /**
     * Returns the array of possible article category values.
     *
     * @return array
     */
    public function getCategoryList()
    {
        $statusArray = [
            self::CATEGORY_ECONOMY => Module::t('Economy'),
            self::CATEGORY_SOCIETY => Module::t('Society'),
            self::CATEGORY_SPORT   => Module::t('Sport'),
        ];

        return $statusArray;
    }
}
