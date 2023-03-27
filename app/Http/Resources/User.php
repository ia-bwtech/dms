<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $custom=[
            'token'=>$this->createToken('MyApp')->accessToken
        ];
        $main=parent::toArray($request);
        $merged=array_merge($main,$custom);
        return $merged;
    }
}
