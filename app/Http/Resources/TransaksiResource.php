<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cust_id' => $this->cust_id,
            'produk_id' => $this->produk_id,
            'jumlah' => $this->jumlah,
            'total_harga' => $this->total_harga,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
