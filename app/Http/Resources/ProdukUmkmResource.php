<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukUmkmResource extends JsonResource
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
            'umkm_id' => $this->umkm_id,
            'nama_produk' => $this->nama_produk,
            'harga_produk' => $this->harga_produk,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
