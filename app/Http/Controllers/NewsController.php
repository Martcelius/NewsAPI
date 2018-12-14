<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Topic;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['getNews', 'showNews']]);
    }

    public function getNews(Request $request)
    {
        $status = $request->query('status');
        $topic = $request->query('topic');
        if ($status && !$topic) {
            $news = News::where('status', $status)->paginate(15);
            $response = [
                'status' => '200',
                'msg' => 'List of all News by status : ' . $status,
                'data' => NewsCollection::collection($news)
            ];
            return response()->json($response, 200);

        } elseif ($topic && !$status) {
            $topic = Topic::where('topic', $topic)->first();

            if (!$topic) {
                $response = [
                    'status' => '404',
                    'msg' => 'Topic not found',
                ];
                return response()->json($response, 404);
            };
            $topics = $topic->news()->paginate(15);
            // return $topic;
            $response = [
                'status' => '200',
                'msg' => 'List of all News from topic : ' . $topic->topic,
                'data' => NewsCollection::collection($topics),
            ];
            return response()->json($response, 200);

        } elseif ($topic && $status) {
            $topic = Topic::where('topic', $topic)->first();
            $news = $topic->news()->where('status', $status)->paginate(15);
            $response = [
                'status' => '200',
                'msg' => 'List of all News from topic : ' . $topic->topic . ' and status :' . $status,
                'data' => NewsCollection::collection($news),
            ];
            return response()->json($response, 200);
        }

        $news = News::paginate(15);
        $response = [
            'status' => 200,
            'msg' => 'List of all News',
            'data' => NewsCollection::collection($news),
        ];

        return response()->json($response, 200);

    }

    public function storeNews(Request $request)
    {
        $this->validate($request, [
            'penulis' => 'required',
            'title' => 'required',
            'body' => 'required',
            'thumbnail' => 'required',
            'status' => 'required',
            'topic_id' => 'required',
        ]);

        $news = new News([
            'penulis' => $request->penulis,
            'title' => $request->title,
            'body' => $request->body,
            'thumbnail' => $request->thumbnail,
            'status' => $request->status
        ]);

        if (!$news->save()) {
            $response = [
                'status' => '404',
                'msg' => 'Failed to create News',
            ];

            return response()->json($response, 400);
        };

        foreach ($request->topic_id as $topic) {
            $news->topics()->attach($topic);
        };

        $response = [
            'status' => '201',
            'msg' => 'Success to create News',
            'data' => new NewsCollection($news)
        ];

        return response()->json($response, 201);
    }

    public function showNews($news_id)
    {
        $news = News::find($news_id);
        if (!$news) {
            $response = [
                'status' => '404',
                'msg' => 'Detail news not found',
            ];
            return response()->json($response, 404);

        };

        $response = [
            'status' => '200',
            'msg' => 'List of detail News',
            'data' => new NewsResource($news),
        ];

        return response()->json($response, 200);

    }

    public function updateNews(Request $request, $news_id)
    {
        $this->validate($request, [
            'penulis' => 'required',
            'title' => 'required',
            'body' => 'required',
            'thumbnail' => 'required',
            'status' => 'required',
            'topic_id' => 'required',
        ]);

        $news = News::find($news_id);

        if (!$news) {
            $response = [
                'status' => '404',
                'msg' => 'News can not founds'
            ];
            return response()->json($response, 404);
        };

        $news->penulis = $request->penulis;
        $news->title = $request->title;
        $news->body = $request->body;
        $news->thumbnail = $request->thumbnail;
        $news->status = $request->status;

        if (!$news->update()) {
            $response = [
                'status' => '400',
                'msg' => 'Failed to update News',
            ];
            return response()->json($response, 400);
        };

        $news->topics()->detach();
        foreach ($request->topic_id as $topic) {
            $news->topics()->attach($topic);
        };

        $response = [
            'status' => '201',
            'msg' => 'Success to update News',
            'data' => new NewsCollection($news)
        ];

        return response()->json($response, 201);
    }

    public function destroyNews($news_id)
    {
        $news = News::find($news_id);
        if (!$news) {
            $response = [
                'status' => '404',
                'msg' => 'News not found'
            ];
            return response()->json($response, 404);
        };

        $topics = $news->topics;
        $news->topics()->detach();
        if (!$news->delete()) {
            foreach ($topics as $topic) {
                $news->topics()->attach($topic);
            };
            $response = [
                'status' => '400',
                'msg' => 'Failed to delete News'
            ];
            return response()->json($response, 400);
        };

        $response = [
            'status' => '200',
            'msg' => 'News deleted',
            'create' => [
                'href' => '/api/v1/news',
                'method' => 'POST',
            ]
        ];

        return response()->json($response, 200);
    }
}
