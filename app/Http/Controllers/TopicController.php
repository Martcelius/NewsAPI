<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\NewsCollection;

class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['getTopic', 'showTopic']]);
    }

    /**
     * @api {get} /api/v1/topics Get all list of Topics
     * @apiVersion 0.1.0
     * @apiName getTopic
     * @apiGroup Topic
     * @apiPermission public
     *
     * @apiDescription Digunakan untuk mendapatkan list dari semua topic.
     *
     * @apiExample Contoh untuk menampilkan semua topic:
     * https://apikumparan.herokuapp.com/api/v1/topics
     *  
     */

    /**
     * @api {get} /api/v1/topics/{topic_id} Get detail list of Topics
     * @apiVersion 0.1.0
     * @apiName getTopicDetail
     * @apiGroup Topic
     * @apiPermission public
     *
     * @apiDescription Digunakan untuk mendapatkan list dari topic yang diinginkan.
     *
     * @apiExample Contoh untuk menampilkan detail topic:
     * https://apikumparan.herokuapp.com/api/v1/topics/1
     * @apiParam {number} id id dari topic yang diinginkan
     *  
     */

    /**
     * @api {post} /api/v1/topics Post new Topics
     * @apiVersion 0.1.0
     * @apiName postTopic
     * @apiGroup Topic
     * @apiPermission auth
     *
     * @apiDescription Digunakan untuk post topic yang diinginkan.
     *
     * @apiExample Contoh untuk post topic baru:
     * https://apikumparan.herokuapp.com/api/v1/topics
     * @apiParam {string} topic topic baru yang diinginkan.
     *  
     */

    /**
     * @api {delete} /api/v1/topics/{topic_id} Delete Topics
     * @apiVersion 0.1.0
     * @apiName deleteTopic
     * @apiGroup Topic
     * @apiPermission auth
     *
     * @apiDescription Digunakan untuk delete topic yang diinginkan.
     *
     * @apiExample Contoh untuk delete topic:
     * https://apikumparan.herokuapp.com/api/v1/topics/1
     * @apiParam {number} id id topic yang ingin di delete.
     *  
     */

    public function getTopic()
    {
        $topics = Topic::paginate(15);
        $response = [
            'status' => '200',
            'msg' => 'List of all Topics',
            'data' => TopicCollection::collection($topics)
        ];

        return response()->json($response, 200);
    }

    public function showTopic($topic_id)
    {
        $topic = Topic::find($topic_id);
        if (!$topic) {
            $response = [
                'status' => '404',
                'msg' => 'Topic not found'
            ];
            return response()->json($response, 404);
        }

        $response = [
            'status' => '200',
            'msg' => 'List of detail topic',
            'data' => new TopicResource($topic)
        ];

        return response()->json($response, 200);
    }

    public function storeTopic(Request $request)
    {
        $this->validate($request, [
            'topic' => 'required',
        ]);

        $topic = new Topic([
            'topic' => $request->topic,
        ]);

        if (!$topic->save()) {
            $response = [
                'status' => '400',
                'msg' => 'Failed to create Topic',
            ];

            return response()->json($response, 400);
        };

        $response = [
            'status' => '201',
            'msg' => 'Success to create Topic',
            'data' => new TopicResource($topic),
        ];

        return response()->json($response, 201);
    }

    public function destroyTopic($topic_id)
    {
        $topic = Topic::find($topic_id);
        if (!$topic) {
            $response = [
                'status' => '404',
                'msg' => 'Topic not found'
            ];
            return response()->json($response, 404);
        };

        $news = $topic->news;
        $topic->news()->detach();
        if (!$topic->delete()) {
            foreach ($news as $news) {
                $topic->news()->attach($news);
            };
            $response = [
                'status' => '400',
                'msg' => 'Failed to delete Topic'
            ];
            return response()->json($response, 400);
        };

        $response = [
            'status' => '200',
            'msg' => 'Topic deleted',
            'create' => [
                'href' => '/api/v1/topic',
                'method' => 'POST',
            ]
        ];

        return response()->json($response, 200);
    }
}
