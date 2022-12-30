<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class postResource extends JsonResource
{
    /**
    * Indicates if the resource's collection keys should be preserved.
    *
    * @var bool
    */
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category_id' => $this->category->id,
            // 'category_id' => new categoryResource($this->category),
            'parent_id' => $this->subcategories->id,
            'image' => $this->image,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
