define({ "api": [
  {
    "type": "delete",
    "url": "/api/v1/news/{news_id}",
    "title": "Delete News",
    "version": "0.1.0",
    "name": "deleteNews",
    "group": "News",
    "permission": [
      {
        "name": "auth"
      }
    ],
    "description": "<p>Digunakan untuk delete News.</p>",
    "examples": [
      {
        "title": "Contoh untuk delete data News:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news/1",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>id news yang ingin di delete</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/api/v1/news",
    "title": "Get all list of News",
    "version": "0.1.0",
    "name": "getNews",
    "group": "News",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Digunakan untuk mendapatkan list dari news yang diinginkan.</p>",
    "examples": [
      {
        "title": "Contoh untuk menampilkan semua news:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news",
        "type": "json"
      },
      {
        "title": "Contoh untuk menampilkan semua news berdasarkan filter status : {draft, publish, deleted}:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news?status=draft",
        "type": "json"
      },
      {
        "title": "Contoh untuk menampilkan semua news berdasarkan filter topic ",
        "content": "https://apikumparan.herokuapp.com/api/v1/news?topic=politik",
        "type": "json"
      },
      {
        "title": "Contoh untuk menampilkan semua news berdasarkan filter topic dan status:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news?topic=politik&status=draft",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>status yang terdapat pada masing-masing news (draft, publish, deleted)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "topic",
            "description": "<p>topik sesuai yang disimpan di record topik</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/api/v1/news/{news_id}",
    "title": "Get detail News",
    "version": "0.1.0",
    "name": "getNewsDetail",
    "group": "News",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Digunakan untuk get detail News.</p>",
    "examples": [
      {
        "title": "Contoh untuk get detail News:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news/1",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>id dari suatu news yang dicari</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "post",
    "url": "/api/v1/news",
    "title": "Post new News",
    "version": "0.1.0",
    "name": "postNews",
    "group": "News",
    "permission": [
      {
        "name": "auth"
      }
    ],
    "description": "<p>Digunakan untuk post data News baru.</p>",
    "examples": [
      {
        "title": "Contoh untuk post data News baru:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "penulis",
            "description": "<p>nama penulis(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>judul dari news baru(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "body",
            "description": "<p>isi dari news baru(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "thumbnail",
            "description": "<p>thumbnail dari news baru(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>status dari news baru (draft,publish,deleted)(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "topic_id",
            "description": "<p>topic dari news berupa topic_id, dapat lebih dari satu value(Required)</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "put",
    "url": "/api/v1/news/{news_id}",
    "title": "Update News",
    "version": "0.1.0",
    "name": "postNewsUpdate",
    "group": "News",
    "permission": [
      {
        "name": "auth"
      }
    ],
    "description": "<p>Digunakan untuk update data News.</p>",
    "examples": [
      {
        "title": "Contoh untuk update data News:",
        "content": "https://apikumparan.herokuapp.com/api/v1/news/1",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "penulis",
            "description": "<p>nama penulis(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>judul dari news (Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "body",
            "description": "<p>isi dari news (Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "thumbnail",
            "description": "<p>thumbnail dari news (Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>status dari news  (draft,publish,deleted)(Required)</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "topic_id",
            "description": "<p>topic dari news berupa topic_id, dapat lebih dari satu value(Required)</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "delete",
    "url": "/api/v1/topics/{topic_id}",
    "title": "Delete Topics",
    "version": "0.1.0",
    "name": "deleteTopic",
    "group": "Topic",
    "permission": [
      {
        "name": "auth"
      }
    ],
    "description": "<p>Digunakan untuk delete topic yang diinginkan.</p>",
    "examples": [
      {
        "title": "Contoh untuk delete topic:",
        "content": "https://apikumparan.herokuapp.com/api/v1/topics/1",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>id topic yang ingin di delete.</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/TopicController.php",
    "groupTitle": "Topic"
  },
  {
    "type": "get",
    "url": "/api/v1/topics",
    "title": "Get all list of Topics",
    "version": "0.1.0",
    "name": "getTopic",
    "group": "Topic",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Digunakan untuk mendapatkan list dari semua topic.</p>",
    "examples": [
      {
        "title": "Contoh untuk menampilkan semua topic:",
        "content": "https://apikumparan.herokuapp.com/api/v1/topics",
        "type": "json"
      }
    ],
    "filename": "app/Http/Controllers/TopicController.php",
    "groupTitle": "Topic"
  },
  {
    "type": "get",
    "url": "/api/v1/topics/{topic_id}",
    "title": "Get detail list of Topics",
    "version": "0.1.0",
    "name": "getTopicDetail",
    "group": "Topic",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Digunakan untuk mendapatkan list dari topic yang diinginkan.</p>",
    "examples": [
      {
        "title": "Contoh untuk menampilkan detail topic:",
        "content": "https://apikumparan.herokuapp.com/api/v1/topics/1",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>id dari topic yang diinginkan</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/TopicController.php",
    "groupTitle": "Topic"
  },
  {
    "type": "post",
    "url": "/api/v1/topics",
    "title": "Post new Topics",
    "version": "0.1.0",
    "name": "postTopic",
    "group": "Topic",
    "permission": [
      {
        "name": "auth"
      }
    ],
    "description": "<p>Digunakan untuk post topic yang diinginkan.</p>",
    "examples": [
      {
        "title": "Contoh untuk post topic baru:",
        "content": "https://apikumparan.herokuapp.com/api/v1/topics",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "topic",
            "description": "<p>topic baru yang diinginkan.</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/TopicController.php",
    "groupTitle": "Topic"
  },
  {
    "type": "post",
    "url": "/api/v1/user/register",
    "title": "Simple register user",
    "version": "0.1.0",
    "name": "userRegister",
    "group": "User",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Digunakan untuk register user dan akan generate token untuk akses endpoint dengan permission:auth.</p>",
    "examples": [
      {
        "title": "Contoh untuk register user:",
        "content": "https://apikumparan.herokuapp.com/api/v1/user/register",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>nama dari user baru</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>email dari user baru</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "password",
            "description": "<p>password dari user baru</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/v1/user/signin",
    "title": "Simple signin user",
    "version": "0.1.0",
    "name": "userSignin",
    "group": "User",
    "permission": [
      {
        "name": "public"
      }
    ],
    "description": "<p>Digunakan untuk signin user dan akan generate token untuk akses endpoint dengan permission:auth.</p>",
    "examples": [
      {
        "title": "Contoh untuk signin user:",
        "content": "https://apikumparan.herokuapp.com/api/v1/user/signin",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>email dari user</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "password",
            "description": "<p>password dari user</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "User"
  }
] });
