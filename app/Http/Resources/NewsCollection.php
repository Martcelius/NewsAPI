<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NewsCollection extends Resource
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
            'penulis' => $this->penulis,
            'title' => $this->title,
            'body' => $this->body,
            'thumbnail' => $this->thumbnail,
            'newsDetail' => [
                'href' => '/api/v1/news/' . $this->id,
                'method' => 'GET'
            ]
        ];
    }
}
