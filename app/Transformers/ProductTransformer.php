<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    // protected $defaultIncludes = [];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    // protected $availableIncludes = [];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int)$product->id,
            'title' => (string)$product->name,
            'detail' => (string)$product->description,
            'stock' => (int)$product->quantity,
            'situation' => (string)$product->status,
            'picture' => url("img/{$product->image}"),
            'seller' => (int)$product->seller_id,
            'creationDate' => (string)$product->created_at,
            'lastChange' => (string)$product->updated_at,
            'deleteDate' => isset($product->deleted_at) ? (string) $product->delete_at : null,

            // HATEOAS SYSTEM
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],
                
                

            ],
        ];
    }

    public function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'name',
            'detail' => 'description',
            'stock' => 'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' => 'seller_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deleteDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


    public function transformedAttribute($index)
    {
        $attributes = [
          
            'id' => 'identifier',
            'name' => 'title',
            'description' => 'detail',
            'quantity' => 'stock',
            'status' => 'situation',
            'image' => 'picture',
            'seller_id' => 'seller',
            
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deleteDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
