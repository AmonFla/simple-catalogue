<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name',
      'content',
      'order',
      'featured'
  ];


  /**
   * Get the category of the product.
   */
  public function category()
  {
      return $this->belongsTo(Category::class,'category_id');
  }
}
