<?php

namespace common\models;

use common\helpers\NumHelper;
use common\traits\EnumTrait;
use common\traits\FindOrExceptionTrait;
use Faker\Provider\Uuid;
use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $goods_id
 * @property string $name
 * @property string $content
 * @property string $distributor_prize
 * @property string $sales_initial
 * @property string $sales_actual
 * @property int $goods_status
 * @property int $sale_status
 * @property string $sales_begin
 * @property string $sales_end
 * @property string $stock_num
 * @property string $store_id
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Goods extends \yii\db\ActiveRecord
{
    use EnumTrait,FindOrExceptionTrait;

    const SEPARATOR = '~';

    const GOODS_STATUS_DRAFT = 0 , GOODS_STATUS_ONLINE = 1 , GOODS_STATUS_OFFLINE = 2 , GOODS_STATUS_DELETE = 3;

    const SALE_STATUS_WAIT_SALE = 1, STATUS_IN_THE_SALE = 2, SALE_STATUS_SOLD_OUT = 3, SALE_STATUS_OVERDUE = 4;

    public $sales_begin_end;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }
    public function behaviors()
    {/*{{{*/
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'blameable' => \yii\behaviors\BlameableBehavior::className(),
        ];
    }/*}}}*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content', 'max_num','sales_initial', 'sales_actual',  'stock_num', 'store_id'], 'required'],
            ['goods_id','setGoodsId','skipOnEmpty' => false,'on' => ['create']],
            [['content','image_url'], 'string'],
            [['distributor_prize', 'sales_initial', 'sales_actual'], 'number','min' => 0],
            [['goods_status', 'sale_status','max_num', 'sales_begin', 'sales_end', 'stock_num', 'store_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['goods_id', 'name'], 'string', 'max' => 255],
            ['sales_begin_end','validateRange'],
            [['goods_id'], 'unique'],
            [['store_id'], 'exist','targetClass' => Store::className(),'targetAttribute' => 'id'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] =  ['name', 'content', 'sales_initial', 'sales_actual','stock_num', 'store_id','goods_id',
                                    'distributor_prize','goods_status', 'sales_begin', 'sales_end','sales_begin_end','image_url'];
        return $scenarios;
    }

    public function setGoodsId(){

        $this->goods_id = self::generateUniqueGoodsId();
    }

    public function validateRange($attr, $params)
    {

        if ($this->hasErrors()) return false;

        $sales_begin_end = explode(self::SEPARATOR, $this->sales_begin_end);
        if (!is_array($sales_begin_end) || count($sales_begin_end) != 2) {
            $this->addError($attr, '发布时间格式错误.');
            return false;
        }

        foreach ($sales_begin_end as $v) {
            $time = strtotime($v);
            $temp[] = $time;
            if ($time === false) {
                $this->addError($attr, '发布时间格式错误.');
                break;
            }
        }
        $this->sales_begin = $temp[0];
        $this->sales_end = $temp[1];

    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品编号',
            'name' => '商品名称',
            'image_url' => '封面图',
            'content' => '商品内容',
            'distributor_prize' => '分销商奖金',
            'sales_initial' => '原价',
            'sales_actual' => '现价',
            'goods_status' => '状态',
            'sale_status' => '售卖状态',
            'sales_begin' => '售卖开始时间',
            'sales_end' => '售卖结束时间',
            'stock_num' => '售卖总量',
            'sales_num' => '已卖数量',
            'store_id' => '商家id',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'updated_at' => '更新时间',
            'updated_by' => '更新人',
        ];
    }

    public static function getEnumData()
    {/*{{{*/
        return [
            'goods_status' => [
                self::GOODS_STATUS_DRAFT   => '编辑中',
                self::GOODS_STATUS_ONLINE  => '上线',
                self::GOODS_STATUS_OFFLINE => '下线',
                self::GOODS_STATUS_DELETE  => '删除',
            ],
            'sale_status' => [
                self::SALE_STATUS_WAIT_SALE => '待售卖',
                self::STATUS_IN_THE_SALE    => '售卖中',
                self::SALE_STATUS_SOLD_OUT  => '已售罄',
                self::SALE_STATUS_OVERDUE   => '过期',
            ],
        ];
    }/*}}}*/

    public static function generateUniqueGoodsId(){

        return NumHelper::randNum(12);
    }


    public function getStore()
    {
        return $this->hasOne(Store::className(),['id' => 'store_id']);
    }
}
