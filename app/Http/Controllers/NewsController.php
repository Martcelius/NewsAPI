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

    /**
     * @api {get} /api/v1/news Get all list of News
     * @apiVersion 0.1.0
     * @apiName getNews
     * @apiGroup News
     * @apiPermission public
     *
     * @apiDescription Digunakan untuk mendapatkan list dari news yang diinginkan.
     *
     * @apiExample Contoh untuk menampilkan semua news:
     * https://apikumparan.herokuapp.com/api/v1/news
     * 
     * @apiExample Contoh untuk menampilkan semua news berdasarkan filter status : {draft, publish, deleted}:
     * https://apikumparan.herokuapp.com/api/v1/news?status=draft
     * 
     * @apiExample Contoh untuk menampilkan semua news berdasarkan filter topic 
     * https://apikumparan.herokuapp.com/api/v1/news?topic=politik
     * 
     * @apiExample Contoh untuk menampilkan semua news berdasarkan filter topic dan status:
     * https://apikumparan.herokuapp.com/api/v1/news?topic=politik&status=draft
     * 
     * @apiParam {string} status status yang terdapat pada masing-masing news (draft, publish, deleted)
     * @apiParam {string} topic topik sesuai yang disimpan di record topik
     */

    /**
     * @api {post} /api/v1/news Post new News
     * @apiVersion 0.1.0
     * @apiName postNews
     * @apiGroup News
     * @apiPermission auth
     *
     * @apiDescription Digunakan untuk post data News baru.
     *
     * @apiExample Contoh untuk post data News baru:
     * https://apikumparan.herokuapp.com/api/v1/news
     * 
     * @apiParam {string} penulis nama penulis(Required)
     * @apiParam {string} title judul dari news baru(Required)
     * @apiParam {string} body isi dari news baru(Required)
     * @apiParam {string} thumbnail thumbnail dari news baru(Required)
     * @apiParam {string} status status dari news baru (draft,publish,deleted)(Required)
     * @apiParam {Array} topic_id topic dari news berupa topic_id, dapat lebih dari satu value(Required)
     * 
     */

    /**
     * @api {get} /api/v1/news/{news_id} Get detail News
     * @apiVersion 0.1.0
     * @apiName getNewsDetail
     * @apiGroup News
     * @apiPermission public
     *
     * @apiDescription Digunakan untuk get detail News.
     *
     * @apiExample Contoh untuk get detail News:
     * https://apikumparan.herokuapp.com/api/v1/news/1
     * @apiParam {number} id id dari suatu news yang dicari
     */

    /**
     * @api {put} /api/v1/news/{news_id} Update News 
     * @apiVersion 0.1.0
     * @apiName postNewsUpdate
     * @apiGroup News
     * @apiPermission auth
     *
     * @apiDescription Digunakan untuk update data News.
     *
     * @apiExample Contoh untuk update data News:
     * https://apikumparan.herokuapp.com/api/v1/news/1
     * 
     * @apiParam {string} penulis nama penulis(Required)
     * @apiParam {string} title judul dari news (Required)
     * @apiParam {string} body isi dari news (Required)
     * @apiParam {string} thumbnail thumbnail dari news (Required)
     * @apiParam {string} status status dari news  (draft,publish,deleted)(Required)
     * @apiParam {Array} topic_id topic dari news berupa topic_id, dapat lebih dari satu value(Required)
     * 
     */

    /**
     * @api {delete} /api/v1/news/{news_id} Delete News
     * @apiVersion 0.1.0
     * @apiName deleteNews
     * @apiGroup News
     * @apiPermission auth
     *
     * @apiDescription Digunakan untuk delete News.
     *
     * @apiExample Contoh untuk delete data News:
     * https://apikumparan.herokuapp.com/api/v1/news/1
     * @apiParam {number} id id news yang ingin di delete
     */

    public function getNews(Request $request)
    {
        $status = $request->query('status');
        $topic = $request->query('topic');
        if ($status && !$topic) {
            $news = News::where('status', $status)->paginate(15);
            $response = [
                'status' => 200,
                'msg' => 'List of all News by status : ' . $status,
                'data' => NewsCollection::collection($news)
            ];
            return response()->json($response, 200);

        } elseif ($topic && !$status) {
            $topic = Topic::where('topic', $topic)->first();

            if (!$topic) {
                $response = [
                    'status' => 404,
                    'msg' => 'Topic not found',
                ];
                return response()->json($response, 404);
            };
            $topics = $topic->news()->paginate(15);
            // return $topic;
            $response = [
                'status' => 200,
                'msg' => 'List of all News from topic : ' . $topic->topic,
                'data' => NewsCollection::collection($topics),
            ];
            return response()->json($response, 200);

        } elseif ($topic && $status) {
            $topic = Topic::where('topic', $topic)->first();
            $news = $topic->news()->where('status', $status)->paginate(15);
            $response = [
                'status' => 200,
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
                'status' => 400,
                'msg' => 'Failed to create News',
            ];

            return response()->json($response, 400);
        };

        foreach ($request->topic_id as $topic) {
            $news->topics()->attach($topic);
        };

        $response = [
            'status' => 201,
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
                'status' => 404,
                'msg' => 'Detail news not found',
            ];
            return response()->json($response, 404);

        };

        $response = [
            'status' => 200,
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
                'status' => 404,
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
                'status' => 400,
                'msg' => 'Failed to update News',
            ];
            return response()->json($response, 400);
        };

        $news->topics()->detach();
        foreach ($request->topic_id as $topic) {
            $news->topics()->attach($topic);
        };

        $response = [
            'status' => 201,
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
                'status' => 404,
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
                'status' => 400,
                'msg' => 'Failed to delete News'
            ];
            return response()->json($response, 400);
        };

        $response = [
            'status' => 200,
            'msg' => 'News deleted',
            'create' => [
                'href' => '/api/v1/news',
                'method' => 'POST',
            ]
        ];

        return response()->json($response, 200);
    }
}
