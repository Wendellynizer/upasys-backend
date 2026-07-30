<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $request->first_name,
            'first_name' => $request->last_name,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ];
    }
}
