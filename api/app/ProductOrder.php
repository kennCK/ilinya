<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends APIModel
{
  protected $fillable = ['id'];
  public function product()
  {
    return $this->belongsTo('\App\Product');
  }
}
