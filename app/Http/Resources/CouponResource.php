<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'discount' => $this->discount,
            'active' => (bool)$this->active,
            'event_start' => (new \DateTime($this->event_start))->format('Y-m-d'),
            'event_end' => (new \DateTime($this->event_end))->format('Y-m-d'),
        ];
    }
}