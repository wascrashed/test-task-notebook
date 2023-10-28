<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotebookResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="NotebookResource",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="full_name", type="string"),
     *     @OA\Property(property="phone", type="string"),
     *     @OA\Property(property="email", type="string"),
     *     @OA\Property(property="birthdate", type="string"),
     *     @OA\Property(property="company", type="string"),
     *     @OA\Property(property="photo", type="string"),
     * )
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'company' => $this->company,
            'photo' => $this->photo,
        ];
    }
}
