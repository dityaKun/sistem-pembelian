@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Dashboard Pembelian</h3>

    <!-- Period Filter Tabs -->
    <div class="period-tabs">
        <a href="?period=daily" class="btn btn-outline-primary {{ $period == 'daily' ? 'active' : '' }}">DAILY</a>
        <a href="?period=weekly" class="btn btn-outline-primary {{ $period == 'weekly' ? 'active' : '' }}">WEEKLY</a>
        <a href="?period=monthly" class="btn btn-outline-primary {{ $period == 'monthly' ? 'active' : '' }}">MONTHLY</a>
        <a href="?period=yearly" class="btn btn-outline-primary {{ $period == 'yearly' ? 'active' : '' }}">YEARLY</a>
    </div>

    <!-- Chart Container -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Grafik Pembelian</h5>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="purchaseChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <h4>Rp {{ number_format($summaryStats['total_purchases'], 0, ',', '.') }}</h4>
            <p>Total Pembelian</p>
        </div>
        <div class="summary-card">
            <h4>{{ $summaryStats['total_transactions'] }}</h4>
            <p>Total Transaksi</p>
        </div>
        <div class="summary-card">
            <h4>Rp {{ number_format($summaryStats['average_purchase'], 0, ',', '.') }}</h4>
            <p>Rata-rata Pembelian</p>
        </div>
        <div class="summary-card">
            <h4>{{ $summaryStats['top_supplier'] }}</h4>
            <p>Supplier Teratas</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('purchaseChart').getContext('2d');

    // Chart configuration
    const config = {
        type: 'line',
        data: @json($chartData),
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Grafik Pembelian Berdasarkan Periode'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    };

    // Create chart
    const purchaseChart = new Chart(ctx, config);

    // Update chart when period changes
    document.querySelectorAll('.period-tabs .btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const period = this.getAttribute('href').split('=')[1];

            // Update active button
            document.querySelectorAll('.period-tabs .btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Fetch new data
            fetch(`/?period=${period}`)
                .then(response => response.text())
                .then(html => {
                    // Parse the new chart data from the response
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');
                    const newScript = newDoc.querySelector('script');
                    if (newScript) {
                        // Extract chart data from the new page
                        const chartDataMatch = html.match(/data:\s*(\{[^}]*\})/);
                        if (chartDataMatch) {
                            const newChartData = JSON.parse(chartDataMatch[1]);
                            purchaseChart.data = newChartData;
                            purchaseChart.update();
                        }
                    }
                });
        });
    });
});
</script>
@endsection
