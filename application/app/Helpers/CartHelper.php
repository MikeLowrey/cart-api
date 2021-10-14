<?php

namespace App\Helpers;

use App\Helpers\SessionHelpersInterface;
use App\Models\Product;

class CartHelper implements SessionHelpersInterface
{
    public function __construct()
    {
        if ($this->get() === null) {
            $this->set($this->empty());
        }
    }

    public function count(): int
    {
        $cart = $this->get();
        return isset($cart['products']) ? count($cart['products']) : 0;
    }

    public function add(Product $product): void
    {
        // @todo: add service how check if product in stock
        $cart = $this->get();
        $cartProductsIds = array_column($cart['products'], 'id');
        $product->amount = $product->amount ?? 1; // @todo improve
        if (in_array($product->id, $cartProductsIds)) {
            $cart['products'] = $this->productCartIncrement($product->id, $cart['products']);
            $this->set($cart);
            return;
        }
        $product['price_sum'] = $product['price'];
        array_push($cart['products'], $product);
        $this->set($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        $index = array_search($productId, array_column($cart['products'], 'id'));

        if ($index === false) {
            return;
        }

        array_splice(
            $cart['products'],
            $index,
            1
        );
        $this->set($cart);
    }

    public function decrease(Product $product): bool
    {
        $cart = $this->get();
        $cartProductsIds = array_column($cart['products'], 'id');

        if (in_array($product->id, $cartProductsIds)) {
            $cart['products'] = $this->productCartIncrement($product->id, $cart['products'], -1);
            $cart['products'] = array_values($cart['products']); // array_values remove possible empty keys
            $this->set($cart);
            return true;
        }
        return false;
    }

    public function clear(): void
    {
        $this->set($this->empty());
    }

    /**
     * Create and return an initial array.
     *
     * @return array <string, array>
     *
     */
    public function empty(): array
    {
        return [
            'products' => [],
        ];
    }

    /**
     * Return the session cart.
     *
     * @return array <string, array>|null
     */
    public function get(): ?array
    {
        return request()->session()->get('cart');
    }

    /**
     * Put ann new item to session cart.
     *
     * @param array <array> $cart
     * @return void
     */
    public function set(array $cart): void
    {
        request()->session()->put('cart', $cart);
    }

    /**
     * Increment amount from an product in the session cart.
     *
     * @param integer $productId
     * @param array <array> $cartItems
     * @param integer $amount
     * @return array <array>
     */
    private function productCartIncrement(int $productId, array $cartItems, int $amount = 1): array
    {
        $cartItems = array_map(function ($item) use ($productId, $amount) {
            if ($productId == $item['id']) {
                if ($item['amount'] == 1 && $amount < 0) {
                    $this->remove($productId);
                    return null;
                } else {
                    $item['amount'] += $amount;
                }

                $item['price_sum'] = $item['amount'] * $item['price'];
            }

            return $item;
        }, $cartItems);

        return array_filter($cartItems);
    }
}
