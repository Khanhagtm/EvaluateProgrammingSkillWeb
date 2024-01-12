<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Form</title>
    <!-- Thêm Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Thêm một số kiểu CSS tùy chỉnh (có thể điều chỉnh theo ý của bạn) */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-input {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            width: 200px;
        }

        .search-button {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            background-color: #f1f1f1;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="search-container">
    <!-- Form tìm kiếm -->
    <form action="{{ route('problems.search') }}" method="get">
        @csrf
        <!-- Input tìm kiếm với icon từ Font Awesome -->
        <input type="text" name="query" class="search-input" placeholder="Search problems">
        <button type="submit" class="search-button">
            <i class="fas fa-search"></i> <!-- Icon tìm kiếm -->
        </button>
    </form>
</div>

</body>
</html>
