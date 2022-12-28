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
            'bets'=>null,
            'wins'=>$this->bets->where('is_won',1)->count(),
            'losses'=>$this->bets->where('is_won',0)->count(),
            'win_percentage'=>($this->bets->where('is_won',1)->count())/($this->bets->count())*100,
            'packages'=>$this->whenLoaded('packages')
        ];
        $main=parent::toArray($request);
        $merged=array_merge($main,$custom);
        return $merged;
    }
}
