<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>圖書館管理系統</title>

    <!-- Bootstrap & jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --info-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            font-family: 'Noto Sans TC', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }


        .main-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-top: 40px;
        }

        .system-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .system-title {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 28px;
            margin: 0;
        }

        .sub-title {
            font-size: 14px;
            color: #888;
            margin-top: 5px;
        }

        .btn {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
        }

        .status-available {
            background-color: rgba(66, 186, 150, 0.15);
            color: #28a745;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .status-unavailable {
            background-color: rgba(247, 37, 133, 0.15);
            color: #dc3545;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .edit-btn,
        .delete-btn {
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 5px;
            font-size: 12px;
        }

        .edit-btn {
            background-color: var(--info-color);
            border-color: var(--info-color);
        }

        .delete-btn {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .export-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .export-buttons .btn {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
        }

        /* 或者為所有按鈕添加一些邊距 */
        .dt-buttons .btn {
            margin-bottom: 24px;
            /* 在每個按鈕之間添加間隔 */
        }
    </style>
</head>

<body>
    <div class="container main-container">
        <div class="system-header">
            <div>
                <h1 class="system-title">圖書館管理系統</h1>
                <p class="sub-title">輕鬆管理您的圖書館藏書</p>
            </div>
            <div>
                <button id="addBookBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    <i class="fas fa-plus"></i> 新增書籍
                </button>
                <button id="refreshButton" class="btn btn-info">
                    <i class="fas fa-sync-alt"></i> 刷新資料
                </button>
            </div>
        </div>

        <table id="booksTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>書名</th>
                    <th>作者</th>
                    <th>分類</th>
                    <th>出版年份</th>
                    <th>可借閱狀態</th>
                    <th>評分</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>


    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">新增書籍</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookForm">
                        <div class="mb-3">
                            <label for="bookTitle" class="form-label">書名</label>
                            <input type="text" class="form-control" id="bookTitle" name="bookTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookAuthor" class="form-label">作者</label>
                            <input type="text" class="form-control" id="bookAuthor" name="bookAuthor" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookGenre" class="form-label">分類</label>
                            <select class="form-select" id="bookGenre" name="bookGenre"> </select>
                        </div>
                        <div class="mb-3">
                            <label for="bookYear" class="form-label">出版年份</label>
                            <input type="text" class="form-control" id="bookYear" name="bookYear">
                        </div>
                        <div class="mb-3">
                            <label for="bookAvailability" class="form-label">可借閱狀態</label>
                            <select id="bookAvailability" class="form-select">
                                <option value="">未設定</option>
                                <option value="1">可借閱</option>
                                <option value="0">已借出</option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="starRating" class="form-label">評分</label>
                            <div id="starRating">
                                <i class="far fa-star text-warning" data-value="1"></i>
                                <i class="far fa-star text-warning" data-value="2"></i>
                                <i class="far fa-star text-warning" data-value="3"></i>
                                <i class="far fa-star text-warning" data-value="4"></i>
                                <i class="far fa-star text-warning" data-value="5"></i>
                            </div>
                            <input type="hidden" id="bookRating" name="bookRating">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="saveBook">儲存書籍</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#booksTable').DataTable({
                processing: true, // 開啟處理中動畫
                pageLength: 5, // 每頁顯示5筆資料
                order: [
                    [0, 'asc']
                ], // 預設依書名(第二欄)排序，升冪
                paging: true, // 啟用分頁
                ajax: {
                    url: 'http://localhost:801/library/getlist',
                    dataSrc: ''
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'author'
                    },
                    {
                        data: 'genre_name', // 顯示 genre_name
                        render: function(data) {
                            return data; // 返回 genre_name 作為書籍類型
                        }
                    },
                    {
                        data: 'year'
                    },
                    {
                        data: 'available',
                        render: function(data) {
                            return data ? '<span class="status-available"><i class="fas fa-check-circle"></i> 可借閱</span>' : '<span class="status-unavailable"><i class="fas fa-times-circle"></i> 已借出</span>';
                        }
                    },
                    {
                        data: 'rating',
                        render: function(data) {
                            let stars = '';
                            let fullStars = Math.floor(data);
                            let halfStar = data % 1 >= 0.5;

                            for (let i = 0; i < fullStars; i++) {
                                stars += '<i class="fas fa-star text-warning"></i>';
                            }

                            if (halfStar) {
                                stars += '<i class="fas fa-star-half-alt text-warning"></i>';
                                fullStars++;
                            }

                            for (let i = fullStars + (halfStar ? 0 : 0); i < 5; i++) {
                                stars += '<i class="far fa-star text-warning"></i>';
                            }

                            return stars + ' <span class="ms-1">(' + data + ')</span>';
                        }
                    },
                    {
                        data: null,
                        width: '120px',
                        className: 'text-center',
                        defaultContent: '<button class="btn btn-sm btn-primary edit-btn"><i class="fas fa-edit"></i> 編輯</button> <button class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt"></i> 刪除</button>',

                        orderable: false
                    }
                ],
                language: {
                    "search": "搜尋:",
                    "lengthMenu": "顯示 _MENU_ 筆資料",
                    "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                    "paginate": {
                        "first": "第一頁",
                        "previous": "上一頁",
                        "next": "下一頁",
                        "last": "最後一頁"
                    },
                    "buttons": {
                        "excel": "匯出 Excel",
                        "pdf": "匯出 PDF",
                        "print": "列印"
                    }
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> 匯出 Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> 匯出 PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> 列印',
                        className: 'btn btn-warning'
                    }
                ]
            });

            // 監聽刪除按鈕
            $('#booksTable tbody').on('click', '.delete-btn', function() {
                if (confirm('確定要刪除此書籍?')) {
                    var row = table.row($(this).parents('tr'));
                    row.remove().draw();
                }
            });

            // 監聽編輯按鈕
            $('#booksTable tbody').on('click', '.edit-btn', function() {
                Swal.fire({
                    title: '功能尚未實現',
                    text: '編輯功能將在未來版本中實現',
                    icon: 'info',
                    confirmButtonText: '確認'
                });

            });

            // 監聽新增書籍按鈕
            $('#addBookBtn').on('click', function() {
                $("#bookTitle").val('');
                $("#bookAuthor").val('');
                $("#bookGenre").val('');
                $("#bookYear").val('');
                $("#bookAvailability").val('');
                $("#bookRating").val('');
                // 清除所有星星樣式
                $("#starRating i").removeClass("fas").addClass("far");
                $.ajax({
                    url: 'http://localhost:801/library/getGenre',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let select = $("#bookGenre");
                        select.empty().append('<option selected value="">請選擇分類</option>');
                        $.each(data, function(index, item) {
                            select.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function() {
                        alert("無法載入分類資料");
                    }
                });

                // Swal.fire({
                //     title: '功能尚未實現',
                //     text: '新增書籍功能將在未來版本中實現',
                //     icon: 'info',
                //     confirmButtonText: '確認'
                // });
            });

            // 評分按鈕
            $("#starRating i").on("click", function() {
                let rating = $(this).data("value");
                $("#bookRating").val(rating);

                // 清除所有星星樣式
                $("#starRating i").removeClass("fas").addClass("far");

                // 填充選中的星星
                $("#starRating i").each(function() {
                    if ($(this).data("value") <= rating) {
                        $(this).removeClass("far").addClass("fas");
                    }
                });
            });

            // 處理表單提交
            $("#saveBook").on('click', function() {
                var bookData = {
                    title: $("#bookTitle").val(),
                    author: $("#bookAuthor").val(),
                    genre: $("#bookGenre").val(),
                    year: $("#bookYear").val(),
                    available: $("#bookAvailability").val(),
                    rating: $("#bookRating").val(),
                };
            

                $.ajax({
                    url: "http://localhost:801/library/addBook", // Replace with your API endpoint
                    method: "POST",
                    data: bookData,
                    success: function(response) {
                        // Handle the response from the backend
                        console.log(response);
                        $('#addBookModal').modal('hide');
                        Swal.fire({
                            title: '系統訊息',
                            text: response.text,
                            icon: response.icon,
                            timer: 1000,
                            showConfirmButton: false // Hide the OK button
                        });
                        // 重新加載表格資料
                        refreshTable();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error("Error:", status, error);
                        Swal.fire({
                            title: '系統訊息',
                            text: '新增書籍失敗',
                            icon: 'error',
                            timer: 1000,
                            showConfirmButton: false // Hide the OK button
                        });

                    }
                });


            });


            // 刷新表格的方法
            function refreshTable() {
                table.ajax.reload(); // 重新加載資料
            }

            // 設置一個按鈕來觸發刷新
            $('#refreshButton').on('click', function() {
                refreshTable(); // 點擊時刷新表格
            });




        });
    </script>
</body>

</html>
