<!DOCTYPE html>
<html>
<head>
    <title>Articles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .pagination { justify-content: center; }
    </style>
</head>
<body>
<div class="container">
    <h1>Articles</h1>
    <div class="input-group mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search by title">
    </div>
    <table id="articlesTable" class="table">
        <thead>
            <tr>
                <th><a href="#" class="sort" data-sort="title">Title</a></th>
                <th><a href="#" class="sort" data-sort="pubDate">Publication Date</a></th>
            </tr>
        </thead>
        <tbody id="articlesBody">
            <!-- Table rows will be dynamically added here -->
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <!-- Pagination buttons will be dynamically added here -->
        </ul>
    </nav>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    let currentPage = 1;
    let sortBy = 'pubDate';
    let sortDirection = 'desc';
    let query = '';

    function fetchArticles() {
        $.ajax({
            url: '/articles',
            data: {
                page: currentPage,
                sortBy: sortBy,
                sortDirection: sortDirection,
                query: query,
            },
            success: function (data) {
                $('#articlesBody').empty();
                if (data.data && data.data.length > 0) {
                    data.data.forEach(article => {
                        $('#articlesBody').append(`
                            <tr>
                                <td>${article.title}</td>
                                <td>${article.pubDate}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#articlesBody').append('<tr><td colspan="2">No articles found</td></tr>');
                }

                $('.pagination').empty();
                for (let i = 1; i <= Math.ceil(data.total / data.per_page); i++) {
                    $('.pagination').append(`<li class="page-item"><a class="page-link" href="#">${i}</a></li>`);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
                console.log(xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        fetchArticles();

        $('#search').on('input', function () {
            query = $(this).val();
            currentPage = 1;
            fetchArticles();
        });

        $(document).on('click', '.sort', function (e) {
            e.preventDefault();
            sortBy = $(this).data('sort');
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            fetchArticles();
        });

        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            currentPage = $(this).text();
            fetchArticles();
        });
    });
</script>
</body>
</html>
