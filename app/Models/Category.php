<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $transformer = CategoryTransformer::class;
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description'
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
