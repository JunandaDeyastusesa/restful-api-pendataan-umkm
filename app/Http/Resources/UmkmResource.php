<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UmkmResource extends JsonResource
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
            'masyarakat_id' => $this->masyarakat_id,
            'nama_usaha' => $this->nama_usaha,
            'alamat_usaha' => $this->alamat_usaha,
            'jenis_usaha' => $this->jenis_usaha,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
