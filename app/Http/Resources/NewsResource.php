<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\TopicCollection;

class NewsResource extends Resource
{
    /**
     * Transform the resource into an array.
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
            'status' => $this->status,
            'created' => $this->created_at,
            'updated' => $this->updated_at,
            'topics' => TopicCollection::collection($this->topics),
            // 'link' => [
            //     'href' => '/api/v1/news/' . $this->id,
            //     'method' => 'GET'
            // ]
        ];
    }
}
