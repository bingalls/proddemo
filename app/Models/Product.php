<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @method static find(array|bool|string|null $id)
 * @method static create(array $array)
 */
class Product extends Model
{
    protected $guarded = ['id'];
}
