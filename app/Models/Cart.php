<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Cart
{
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart)
	{
		if ($oldCart) {
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($item, $id)
	{
		$mathang = ['qty' => 0, 'price' => $item->promotion_price == 0 ? $item->unit_price : $item->promotion_price, 'item' => $item];
		if ($this->items) {
			if (array_key_exists($id, $this->items)) {
				$mathang = $this->items[$id];
			}
		}
		$mathang['qty']++;
		$mathang['price'] = $item->promotion_price == 0 ? $item->unit_price : $item->promotion_price * $mathang['qty'];
		$this->items[$id] = $mathang;
		$this->totalQty++;
		$this->totalPrice += ($item->promotion_price == 0 ? $item->unit_price : $item->promotion_price);
	}

	public function addMany($item, $id, $soluong)
	{
		$mathang = ['qty' => 0, 'price' => $item->promotion_price == 0 ? $item->unit_price : $item->promotion_price, 'item' => $item];
		if ($this->items) {
			if (array_key_exists($id, $this->items)) {
				$mathang = $this->items[$id];
			}
		}
		$mathang['qty'] = $mathang['qty'] + $soluong;
		$mathang['price'] = ($item->promotion_price == 0 ? $item->unit_price : $item->promotion_price) * $mathang['qty'];
		$this->items[$id] = $mathang;
		$this->totalQty += $soluong;
		$this->totalPrice += ($item->promotion_price == 0 ? $item->unit_price : $item->promotion_price) * $soluong;
	}

	public function reduceByOne($id)
	{
		$this->items[$id]['qty']--;
		$this->items[$id]['price'] -= $this->items[$id]['item']['price'];
		$this->totalQty--;
		$this->totalPrice -= $this->items[$id]['item']['price'];
		if ($this->items[$id]['qty'] <= 0) {
			unset($this->items[$id]);
		}
	}

	public function removeItem($id)
	{
		$this->totalQty -= $this->items[$id]['qty'];
		$this->totalPrice -= $this->items[$id]['price'];
		unset($this->items[$id]);
	}
	public function increaseByOne($id)
	{
		$this->items[$id]['qty']++;
		$this->items[$id]['price'] += ($this->items[$id]['item']->promotion_price == 0 ? $this->items[$id]['item']->unit_price : $this->items[$id]['item']->promotion_price);
		$this->totalQty++;
		$this->totalPrice += ($this->items[$id]['item']->promotion_price == 0 ? $this->items[$id]['item']->unit_price : $this->items[$id]['item']->promotion_price);
	}
}

// namespace App\Models;

// class Cart
// {
// public $items = [];
// public $totalQty = 0;
// public $totalPrice = 0;

// public function __construct($oldCart)
// {
// if ($oldCart) {
// $this->items = $oldCart->items;
// $this->totalQty = $oldCart->totalQty;
// $this->totalPrice = $oldCart->totalPrice;
// }
// }

// public function add($item, $id)
// {
// $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
// if ($this->items && array_key_exists($id, $this->items)) {
// $storedItem = $this->items[$id];
// }
// $storedItem['qty']++;
// $storedItem['price'] = $item->price * $storedItem['qty'];
// $this->items[$id] = $storedItem;
// $this->totalQty++;
// $this->totalPrice += $item->price;
// }

// //xóa 1
// public function reduceByOne($id)
// {
// $this->items[$id]['qty']--;
// $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
// $this->totalQty--;
// $this->totalPrice -= $this->items[$id]['item']['price'];
// if ($this->items[$id]['qty'] <= 0) {
	// unset($this->items[$id]);
	// }
	// }
	// //xóa nhiều
	// public function removeItem($id)
	// {
	// $this->totalQty -= $this->items[$id]['qty'];
	// $this->totalPrice -= $this->items[$id]['price'];
	// unset($this->items[$id]);
	// }
	// }
