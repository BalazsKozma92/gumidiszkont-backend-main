<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public static $wrap = false;

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'published' => (bool)$this->published,
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
        ];
    }
}