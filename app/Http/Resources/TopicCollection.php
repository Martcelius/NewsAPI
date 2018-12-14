<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TopicCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'topic' => $this->topic,
            'detailTopic' => [
                'href' => '/api/v1/topic/' . $this->id,
                'method' => 'GET'
            ],
        ];
    }
}