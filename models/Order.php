<?php

namespace Av\Models;


use Av\Core\Database\DB;
use Av\Core\Kernel;
use Av\Core\Models\Model;

/**
 * Class Order
 * @package Av\Models
 */
class Order extends Model
{
    /**
     * @inheritdoc
     */
    protected static $tableName = 'orders';

    /**
     * @var int
     */
    public $price = 0;
    /**
     * @var int
     */
    public $amount = 0;
    /**
     * @var int
     */
    public $discount = 0;

    /**
     * @inheritdoc
     */
    protected static $ignore = ['products', 'price', 'amount', 'discount'];

    /**
     * @inheritdoc
     */
    public static function create($data)
    {
        $data['hash'] = self::generateHash();
        $order = parent::create($data);

        $products = [];
        if (!empty($data['products'])) {
            $order->products = $data['products'];

            $placeholders = array_fill(0, 3, '?');
            $placeholders = implode(',', $placeholders);

            $query = "INSERT INTO order_items (oid, pid, quantity) VALUES ({$placeholders})";
            foreach ($order->products as $pid => $quantity) {
                $params = [$order->getId(), $pid, $quantity];
                DB::run($query, $params);
            }

        }
        return $order;
    }

    /**
     * Override default load.
     *
     * @param $id
     * @param string $column
     * @return \Av\Core\Models\IModel|mixed
     * @throws \Exception
     */
    public static function load($id, $column = 'id')
    {
        $order = parent::load($id, $column);

        $query = "SELECT pid, quantity FROM order_items where oid = {$order->getId()}";
        $products = DB::all($query);
        foreach ($products as $item) {
            try {
                $product = Product::load($item->pid);
                $product->quantity = $item->quantity;
            } catch (\Exception $ex) {
                $product = null;
            }

            if (!empty($product)) {
                $order->products[$product->getId()] = $product;
            }
        }

        $query = "SELECT * FROM bonuses where id = {$order->bid}";
        $bonus = DB::get($query, Bonus::class);
        if (!empty($bonus)) {
            $order->bonus = $bonus;
        }

        $order->getPrepareData();

        return $order;
    }

    /**
     * Helper for calculating price, quantity and discount.
     */
    public function getPrepareData()
    {
        if (!empty($this->products)) {
            foreach ($this->products as $product) {
                $this->amount += $product->quantity;
                $this->price += $product->price * $product->quantity;
            }

            if ($this->amount >= 3) {
                $this->discount += 10;
            }

            if (!empty($this->bonus)) {
                $this->discount += $this->bonus->discount;
            }

            if ($this->discount) {
                $this->price = $this->price * (1 - $this->discount / 100);
            }
        }
    }

    /**
     * Helper function for generating hash.
     *
     * @return string
     *
     * @todo secure notice
     */
    public static function generateHash()
    {
        return md5(Kernel::$key . session()->getId() . time());
    }

}