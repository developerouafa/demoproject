<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class categoryResource extends JsonResource
{
    /**
    * Indicates if the resource's collection keys should be preserved.
    *
    * @var bool
    */
    // public $preserveKeys = true;

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
            'status' => $this->status,
            'image' => $this->image,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
