<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    // protected $defaultIncludes = [// ];
    
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
    public function transform(Category $category)
    {
        return [
            'identifier' => (int)$category->id,
            'title' => (string)$category->name,
            'detail' => (string)$category->description,
            'creationDate' => (string)$category->created_at,
            'lastChange' => (string)$category->updated_at,
            'deleteDate' => isset($category->deleted_at) ? (string) $category->delete_at : null,

            // HATEOAS SYSTEM
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $category->id),
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
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deleteDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
