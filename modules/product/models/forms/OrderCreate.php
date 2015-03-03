<?php

namespace product\models\forms;

use product\models\OrderValue;
use product\models\Product;
use yii\base\Model;
use product\models\Order;
use product\models\OrderProfile;


class OrderCreate extends Model
{
    /** @var  Order */
    public $order;

    /** @var array */
    public $products = [];

    /** @var string */
    public $username;

    /** @var string */
    public $phone;

    /** @var string */
    public $email;


    public function rules()
    {
        return [
            ['username', 'required', 'message' => 'Введите, пожалуйста, Ваше имя'],

            ['email', 'required', 'message' => 'Введите, пожалуйста, E-Mail'],
            ['email', 'email', 'message' => 'Проверьте правильность E-Mail'],

            ['phone', 'required', 'message' => 'Введите, пожалуйста, Ваш телефон'],

            ['products', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        $productsIds = $this->products;
        if (empty($productsIds)) {
            $this->addError('productsIds','Невозмонжно созадать заказ, ничего не выбрав...');
            return false;
        }
        if (!is_array($productsIds)) {
            $productsIds = [$productsIds];
        }
        foreach ($productsIds as $productId) {
            /** @var Product $product */
            if (!$product = Product::find($productId)) {
                $this->addError('productsIds', 'Продуктов нет в наличии');
                return false;
            }
        }
        return true;
    }


    /**
     * Save club
     *
     * @param bool $validate
     * @return bool|int article id
     * @throws
     */
    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        $trans = \Yii::$app->db->beginTransaction();
        try {

            $orderProfile           = new OrderProfile();
            $orderProfile->username = $this->username;
            $orderProfile->phone    = $this->phone;
            $orderProfile->email    = $this->email;
            $orderProfile->save(false);

            $order                      = new Order();
            $order->order_profile_id    = $orderProfile->id;
            $order->is_deleted          = 0;
            $order->is_closed           = 0;
            $order->save(false);

            $this->order = $order;

            $this->processProducts($this->products, $order->id);

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            throw $e;
        }

        return $order->id;
    }

    public function processProducts($products, $orderId)
    {
        foreach ($products as $productId => $count) {
            $orderValue = new OrderValue([
                'product_id'    => $productId,
                'order_id'      => $orderId,
                'count'         => $count,
            ]);
            $orderValue->save(false);
        }
    }

    public function processProductByCard(array $products)
    {
        $result = [];
        foreach ($products as $id => $product) {
            $result[$id]['count']   = $product['count'];
            $result[$id]['product'] = Product::findOne(['id' => $id]);
        }

        return $result;
    }

}