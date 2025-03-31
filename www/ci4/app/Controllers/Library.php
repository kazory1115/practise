<?php

namespace App\Controllers;


use  App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\GenreModel;
use CodeIgniter\Database\Config;
use Exception;

class Library extends BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // 允許從指定來源進行跨域請求
        header('Access-Control-Allow-Origin: http://localhost:801'); // 修改為你實際的來源
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');
    }
    public function index()
    {
        return view('library');
    }

    // 獲取所有圖書
    public function getList()
    {
        $books = $this->db->table('library')
            ->select('library.id, library.title, library.author, library.year, library.available, library.rating, genre.name as genre_name')
            ->join('genre', 'genre.id = library.genre', 'left') // LEFT JOIN 以防有些資料沒有對應的 genre
            ->get()->getResultArray();

        // 處理資料
        foreach ($books as &$book) {
            // 顯示可用狀態
            $book['available'] = $book['available'] == 1 ? true : false;
        }


        return $this->response->setJSON($books); // 使用 CodeIgniter 內建 JSON 回應
    }

    // 獲取所有圖書分類
    public function getGenres()
    {
        $genres = $this->db->table('genre')->get()->getResultArray();
        return $this->response->setJSON($genres); // 使用 CodeIgniter 內建 JSON 回應

    }
    public function test()
    {
        return view('library_fm');
    }


    public function createTest()
    {
        $books = [
            [
                'id' => 1,
                'title' => "偉大的蓋茨比",
                'author' => "費茲傑羅",
                'genre' => 1, // 小說
                'year' => 1925,
                'available' => 1,
                'rating' => 4.5
            ],
            [
                'id' => 2,
                'title' => "一九八四",
                'author' => "喬治·歐威爾",
                'genre' => 2, // 反烏托邦
                'year' => 1949,
                'available' => 0,
                'rating' => 4.8
            ],
            [
                'id' => 3,
                'title' => "百年孤獨",
                'author' => "加布里埃爾·賈西亞·馬奎斯",
                'genre' => 3, // 魔幻現實
                'year' => 1967,
                'available' => 1,
                'rating' => 4.7
            ],
            [
                'id' => 4,
                'title' => "傲慢與偏見",
                'author' => "珍·奧斯汀",
                'genre' => 1, // 小說
                'year' => 1813,
                'available' => 0,
                'rating' => 4.6
            ],
            [
                'id' => 5,
                'title' => "戰爭與和平",
                'author' => "列夫·托爾斯泰",
                'genre' => 4, // 歷史小說
                'year' => 1869,
                'available' => 1,
                'rating' => 4.9
            ],
            [
                'id' => 6,
                'title' => "追風箏的人",
                'author' => "卡勒德·胡賽尼",
                'genre' => 1, // 小說
                'year' => 2003,
                'available' => 0,
                'rating' => 4.7
            ],
            [
                'id' => 7,
                'title' => "哈利波特：神秘的魔法石",
                'author' => "J.K.羅琳",
                'genre' => 5, // 奇幻
                'year' => 1997,
                'available' => 1,
                'rating' => 4.8
            ],
            [
                'id' => 8,
                'title' => "小王子",
                'author' => "安東尼·德·聖修伯里",
                'genre' => 6, // 寓言
                'year' => 1943,
                'available' => 0,
                'rating' => 4.9
            ],
            [
                'id' => 9,
                'title' => "三體",
                'author' => "劉慈欣",
                'genre' => 7, // 科幻
                'year' => 2008,
                'available' => 1,
                'rating' => 4.9
            ],
            [
                'id' => 10,
                'title' => "老人與海",
                'author' => "海明威",
                'genre' => 1, // 小說
                'year' => 1952,
                'available' => 0,
                'rating' => 4.4
            ],
            [
                'id' => 11,
                'title' => "活著",
                'author' => "余華",
                'genre' => 1, // 小說
                'year' => 1993,
                'available' => 1,
                'rating' => 4.8
            ],
            [
                'id' => 12,
                'title' => "圍城",
                'author' => "錢鍾書",
                'genre' => 1, // 小說
                'year' => 1947,
                'available' => 0,
                'rating' => 4.7
            ],
            [
                'id' => 13,
                'title' => "悲慘世界",
                'author' => "維克多·雨果",
                'genre' => 4, // 歷史小說
                'year' => 1862,
                'available' => 1,
                'rating' => 4.6
            ],
            [
                'id' => 14,
                'title' => "飢餓遊戲",
                'author' => "蘇珊·柯林斯",
                'genre' => 7, // 科幻
                'year' => 2008,
                'available' => 0,
                'rating' => 4.5
            ]
        ];

        $genres = [
            [
                'id' => 1,
                'name' => "小說"
            ],
            [
                'id' => 2,
                'name' => "反烏托邦"
            ],
            [
                'id' => 3,
                'name' => "魔幻現實"
            ],
            [
                'id' => 4,
                'name' => "歷史小說"
            ],
            [
                'id' => 5,
                'name' => "奇幻"
            ],
            [
                'id' => 6,
                'name' => "寓言"
            ],
            [
                'id' => 7,
                'name' => "科幻"
            ]
        ];

        try {
            $db = db_connect(); // 確保取得資料庫連線

            // 啟動交易
            $db->transStart();

            // 插入書籍資料
            $db->table('library')->insertBatch($books);

            // 插入類別資料
            $db->table('genre')->insertBatch($genres);

            // 提交交易
            $db->transComplete();

            if ($db->transStatus() === false) {
                $db->transRollback();
                echo "錯誤：寫入失敗";
            }

            echo "批量寫入成功！";
        } catch (Exception $e) {
            // 發生錯誤時回滾交易
            $db->transRollback();
            echo "錯誤：" . $e->getMessage();
        }
    }

    // 創建新圖書
    public function createBook()
    {
        $bookData = [
            'title'     => $this->request->getPost('title'),
            'author'    => $this->request->getPost('author'),
            'genre'     => $this->request->getPost('genre'),
            'year'      => $this->request->getPost('year'),
            'available' => $this->request->getPost('available'),
            'rating'    => $this->request->getPost('rating'),
        ];
        $db  = db_connect(); // 確保取得資料庫連線

        try {
            // 啟動交易
            $db->transStart();

            // 插入書籍資料
            $db->table('library')->insert($bookData);

            // 提交交易
            $db->transComplete();

            if ($db->transStatus() === false) {
                $db->transRollback();
                $result = [
                    'icon' => 'error',
                    'text' => '寫入失敗',
                ];
            }
            $result =   [
                'icon' => 'success',
                'text' => '新增成功',
            ];
        } catch (Exception $e) {
            // 發生錯誤時回滾交易
            $db->transRollback();
            $result =  [
                'icon' => 'success',
                'text' => '新增失敗',
            ];
        }
        return $this->response->setJSON($result);
    }

    // 更新圖書
    public function updateBook($id = null) {}

    // 刪除圖書
    public function deleteBook($id = null) {}
}
