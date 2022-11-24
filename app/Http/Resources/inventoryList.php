<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class inventoryList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total = $this->details->sum('total') - $this->out->sum('total');
        return [
          'id' => $this->id,
          'product' => $this->product->name,
          'product_id' => $this->product->id,
          'unit' => $this->unit->name,
          'unit_id' => $this->unit->id,
          'total' => $total,
        ];
    }
}
