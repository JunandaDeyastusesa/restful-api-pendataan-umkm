<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasyarakatResource extends JsonResource
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
            'nik' => $this->nik,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
