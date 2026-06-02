<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' =>    empty($this->image)  ? null : url('storage/images/payment/payment_methods/'.$this->image),
            'view_order' => $this->view_order,
            'is_active' => $this->is_active,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
