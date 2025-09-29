<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: linear-gradient(to bottom, #007bff, #0044cc);
            color: #fff;
            padding: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            margin: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4>Menu</h4>
        <a href="{{ url('/masterdata') }}">Master Data</a>
        <a href="{{ url('/pembelian') }}">Data Pembelian</a>
        <a href="{{ url('/pembelian/create') }}">Tambah Pembelian</a>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
