<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_id',
        'product_id',
        'token',
        'amount'
    ];

    /**
     * Return User which related to this Cart
     * @todo copy cartSession Data after authentication to the carts table
     * with relation to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return belongsTo(User::class);
    }

    /**
     * Return related Product Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return belongsTo(Product::class);
    }
}
