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
		// Khởi tạo mặt hàng với số lượng và giá ban đầu
		$mathang = ['qty' => 0, 'price' => 0, 'item' => $item];
		if ($this->items && array_key_exists($id, $this->items)) {
			$mathang = $this->items[$id];
		}

		// Tăng số lượng lên 1
		$mathang['qty']++;

		// Tính giá đơn vị (unit_price hoặc promotion_price)
		$itemPrice = $item->promotion_price == 0 ? $item->unit_price : $item->promotion_price;

		// Tính lại price của mặt hàng
		$mathang['price'] = $itemPrice * $mathang['qty'];

		// Lưu mặt hàng vào giỏ
		$this->items[$id] = $mathang;

		// Cập nhật totalQty và totalPrice
		$this->totalQty++;
		$this->totalPrice = 0;
		foreach ($this->items as $item) {
			$this->totalPrice += $item['price'];
		}
	}

	public function addMany($item, $id, $soluong)
	{
		// Khởi tạo mặt hàng
		$mathang = ['qty' => 0, 'price' => 0, 'item' => $item];
		if ($this->items && array_key_exists($id, $this->items)) {
			$mathang = $this->items[$id];
		}

		// Cộng thêm số lượng
		$mathang['qty'] += $soluong;

		// Tính giá đơn vị
		$itemPrice = $item->promotion_price == 0 ? $item->unit_price : $item->promotion_price;

		// Tính lại price của mặt hàng
		$mathang['price'] = $itemPrice * $mathang['qty'];

		// Lưu mặt hàng vào giỏ
		$this->items[$id] = $mathang;

		// Cập nhật totalQty và totalPrice
		$this->totalQty += $soluong;
		$this->totalPrice = 0;
		foreach ($this->items as $item) {
			$this->totalPrice += $item['price'];
		}
	}

	public function reduceByOne($id)
	{
		if (isset($this->items[$id])) {
			// Giảm số lượng đi 1
			$this->items[$id]['qty']--;

			// Tính giá đơn vị
			$itemPrice = $this->items[$id]['item']->promotion_price == 0
				? $this->items[$id]['item']->unit_price
				: $this->items[$id]['item']->promotion_price;

			// Tính lại price của mặt hàng
			$this->items[$id]['price'] = $itemPrice * $this->items[$id]['qty'];

			// Nếu số lượng <= 0, xóa mặt hàng
			if ($this->items[$id]['qty'] <= 0) {
				unset($this->items[$id]);
			}

			// Cập nhật lại totalQty và totalPrice
			$this->totalQty = 0;
			$this->totalPrice = 0;
			foreach ($this->items as $item) {
				$this->totalQty += $item['qty'];
				$this->totalPrice += $item['price'];
			}
		}
	}

	public function increaseByOne($id)
	{
		if (isset($this->items[$id])) {
			// Tăng số lượng lên 1
			$this->items[$id]['qty']++;

			// Tính giá đơn vị
			$itemPrice = $this->items[$id]['item']->promotion_price == 0
				? $this->items[$id]['item']->unit_price
				: $this->items[$id]['item']->promotion_price;

			// Tính lại price của mặt hàng
			$this->items[$id]['price'] = $itemPrice * $this->items[$id]['qty'];

			// Cập nhật lại totalQty và totalPrice
			$this->totalQty = 0;
			$this->totalPrice = 0;
			foreach ($this->items as $item) {
				$this->totalQty += $item['qty'];
				$this->totalPrice += $item['price'];
			}
		}
	}

	public function removeItem($id)
	{
		if (isset($this->items[$id])) {
			// Cập nhật totalQty và totalPrice trước khi xóa
			$this->totalQty -= $this->items[$id]['qty'];
			$this->totalPrice -= $this->items[$id]['price'];

			// Xóa mặt hàng
			unset($this->items[$id]);
		}
	}
}
