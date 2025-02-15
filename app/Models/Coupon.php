<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = "coupon";
    protected $fillable = ['coupon_name', 'percentage', 'multipleUsage', 'status', 'coupon_code'];
}
