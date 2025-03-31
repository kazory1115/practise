<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">新增書籍</button>

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
                            <label for="bookPublisher" class="form-label">出版社</label>
                            <input type="text" class="form-control" id="bookPublisher" name="bookPublisher">
                        </div>
                        <div class="mb-3">
                            <label for="bookPrice" class="form-label">價格</label>
                            <input type="number" class="form-control" id="bookPrice" name="bookPrice" min="0" step="0.1">
                        </div>
                        <div class="mb-3">
                            <label for="bookCategory" class="form-label">分類</label>
                            <select class="form-select" id="bookCategory" name="bookCategory">
                                <option selected value="">請選擇分類</option>
                                <option value="文學">文學</option>
                                <option value="科技">科技</option>
                                <option value="歷史">歷史</option>
                                <option value="其他">其他</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bookDescription" class="form-label">書籍描述</label>
                            <textarea class="form-control" id="bookDescription" name="bookDescription" rows="3"></textarea>
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
</body>

</html>