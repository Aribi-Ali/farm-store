<?php

use App\Exceptions\CustomNotFoundException;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
  const DEFAULT_PER_PAGE = 15;
  public function create($orderData)
  {
    // create the orders and order items
    return DB::transaction(function () use ($orderData) {
      $order = Order::create($orderData);
      $order->items()->createMany($orderData['items']);
      return $order;
    });
  }

  public function show($orderId)
  {
    $order = Order::findOr($orderId, function () use ($orderId) {
      throw new CustomNotFoundException("Order with ID {$orderId} was not found.", 404);
    });

    return $order;
  }
  public function update($orderId, $orderData)
  {
    $order = Order::findOr($orderId, function () use ($orderId) {
      throw new CustomNotFoundException("Order with ID {$orderId} was not found.", 404);
    });

    return DB::transaction(function () use ($orderData, $order) {
      return $order->update($orderData);
    });
  }

  public function delete($orderId)
  {
    $order = Order::findOr($orderId, function () use ($orderId) {
      throw new CustomNotFoundException("Order with ID {$orderId} was not found.", 404);
    });

    return DB::transaction(function () use ($order) {
      return $order->delete();
    });
  }

  public function getPaginated(array $filters = [], int|null $perPage = self::DEFAULT_PER_PAGE)
  {
    $query = Order::query();
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%');
    }

    return $query->paginate($perPage);
  }
  public function getUserOrders($userId, int|null $perPage = self::DEFAULT_PER_PAGE)
  {
    $query = Order::query();
    $query->where('user_id', $userId);
    return $query->paginate($perPage);
  }


  // private funciton
  /* function calculateShippingCost($cart, $cityId, $wilayaId, $storeId)
  {
    $totalShipping = 0;

    foreach ($cart->items as $item) {
      if ($item->product->free_shipping) {
        continue; // Skip free shipping products
      }

      if ($item->product->has_custom_shipping) {
        $totalShipping += $item->product->custom_shipping_cost;
      } else {
        // Fallback to store-level shipping cost
        $shippingCost = ShippingCost::where('store_id', $storeId)
          ->where(function ($query) use ($cityId, $wilayaId) {
            $query->where('city_id', $cityId)
              ->orWhere('wilaya_id', $wilayaId);
          })
          ->value('cost');
        $totalShipping += $shippingCost;
      }
    }

    return $totalShipping;
  }
*/
}
