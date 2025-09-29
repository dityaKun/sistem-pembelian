<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 280px;
            background: #4e73df;
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h4 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            font-size: 1.2em;
        }
        .sidebar a {
            display: block;
            color: #fff;
            padding: 15px 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
            border-left-color: #fff;
            transform: translateX(5px);
        }
        .sidebar a.active {
            background-color: rgba(255,255,255,0.2);
            border-left-color: #fff;
        }
        .sidebar i {
            margin-right: 10px;
            font-size: 1.1em;
        }
        .content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }
        .page-title {
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .btn-custom {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .table th {
            background-color: #5a5c69;
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f1f3f4;
        }
        .action-buttons .btn {
            margin: 0 2px;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .date-input {
            max-width: 150px;
        }
        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
        .btn-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 30px;
        }
        .period-tabs {
            margin-bottom: 20px;
        }
        .period-tabs .btn {
            margin-right: 10px;
            border-radius: 20px;
        }
        .period-tabs .btn.active {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .summary-card h4 {
            color: #4e73df;
            font-size: 2em;
            margin-bottom: 10px;
        }
        .summary-card p {
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>PEMBELIAN</h4>
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>Dashboard
        </a>
        <a href="{{ url('/masterdata') }}" class="{{ request()->is('masterdata*') ? 'active' : '' }}">
            <i class="bi bi-database"></i>Master Data
        </a>
        <a href="{{ url('/pembelian') }}" class="{{ request()->is('pembelian*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>Data Pembelian
        </a>
        <a href="{{ route('pembelian.create') }}" class="{{ request()->is('pembelian/create*') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>Tambah Pembelian
        </a>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
