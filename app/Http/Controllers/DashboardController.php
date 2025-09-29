<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $chartData = $this->getChartData($period);
        $summaryStats = $this->getSummaryStats();

        return view('dashboard', compact('chartData', 'summaryStats', 'period'));
    }

    private function getChartData($period)
    {
        $data = [];
        $labels = [];

        switch ($period) {
            case 'daily':
                $data = $this->getDailyData();
                $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                break;
            case 'weekly':
                $data = $this->getWeeklyData();
                $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                break;
            case 'yearly':
                $data = $this->getYearlyData();
                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                break;
            default: // monthly
                $data = $this->getMonthlyData();
                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                break;
        }

        return [
            'labels' => $labels,
            'datasets' => $data
        ];
    }

    private function getMonthlyData()
    {
        $suppliers = Pembelian::distinct('nama_supplier')->pluck('nama_supplier');
        $datasets = [];

        $colors = [
            '#4e73df', // Blue
            '#1cc88a', // Green
            '#f6c23e', // Yellow
            '#e74a3b', // Red
            '#6f42c1', // Purple
            '#36b9cc', // Teal
            '#f8c471', // Light Orange
            '#82e0aa', // Light Green
        ];

        $i = 0;
        foreach ($suppliers as $supplier) {
            $monthlyData = [];
            for ($month = 1; $month <= 12; $month++) {
                $total = Pembelian::where('nama_supplier', $supplier)
                                 ->whereMonth('tanggal', $month)
                                 ->whereYear('tanggal', date('Y'))
                                 ->sum('grand_total');
                $monthlyData[] = $total;
            }

            $datasets[] = [
                'label' => $supplier,
                'data' => $monthlyData,
                'borderColor' => $colors[$i % count($colors)],
                'backgroundColor' => $colors[$i % count($colors)] . '20', // Add transparency
                'tension' => 0.4,
                'fill' => false
            ];
            $i++;
        }

        return $datasets;
    }

    private function getDailyData()
    {
        $suppliers = Pembelian::distinct('nama_supplier')->pluck('nama_supplier');
        $datasets = [];

        $colors = [
            '#4e73df', // Blue
            '#1cc88a', // Green
            '#f6c23e', // Yellow
            '#e74a3b', // Red
            '#6f42c1', // Purple
            '#36b9cc', // Teal
            '#f8c471', // Light Orange
            '#82e0aa', // Light Green
        ];

        $i = 0;
        foreach ($suppliers as $supplier) {
            $dailyData = [];
            for ($day = 0; $day < 7; $day++) {
                $date = Carbon::now()->startOfWeek()->addDays($day);
                $total = Pembelian::where('nama_supplier', $supplier)
                                 ->whereDate('tanggal', $date)
                                 ->sum('grand_total');
                $dailyData[] = $total;
            }

            $datasets[] = [
                'label' => $supplier,
                'data' => $dailyData,
                'borderColor' => $colors[$i % count($colors)],
                'backgroundColor' => $colors[$i % count($colors)] . '20',
                'tension' => 0.4,
                'fill' => false
            ];
            $i++;
        }

        return $datasets;
    }

    private function getWeeklyData()
    {
        $suppliers = Pembelian::distinct('nama_supplier')->pluck('nama_supplier');
        $datasets = [];

        $colors = [
            '#4e73df', // Blue
            '#1cc88a', // Green
            '#f6c23e', // Yellow
            '#e74a3b', // Red
            '#6f42c1', // Purple
            '#36b9cc', // Teal
            '#f8c471', // Light Orange
            '#82e0aa', // Light Green
        ];

        $i = 0;
        foreach ($suppliers as $supplier) {
            $weeklyData = [];
            for ($week = 0; $week < 4; $week++) {
                $startOfWeek = Carbon::now()->startOfMonth()->addWeeks($week);
                $endOfWeek = Carbon::now()->startOfMonth()->addWeeks($week + 1)->subDay();

                $total = Pembelian::where('nama_supplier', $supplier)
                                 ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
                                 ->sum('grand_total');
                $weeklyData[] = $total;
            }

            $datasets[] = [
                'label' => $supplier,
                'data' => $weeklyData,
                'borderColor' => $colors[$i % count($colors)],
                'backgroundColor' => $colors[$i % count($colors)] . '20',
                'tension' => 0.4,
                'fill' => false
            ];
            $i++;
        }

        return $datasets;
    }

    private function getYearlyData()
    {
        $suppliers = Pembelian::distinct('nama_supplier')->pluck('nama_supplier');
        $datasets = [];

        $colors = [
            '#4e73df', // Blue
            '#1cc88a', // Green
            '#f6c23e', // Yellow
            '#e74a3b', // Red
            '#6f42c1', // Purple
            '#36b9cc', // Teal
            '#f8c471', // Light Orange
            '#82e0aa', // Light Green
        ];

        $i = 0;
        foreach ($suppliers as $supplier) {
            $yearlyData = [];
            for ($yearOffset = 4; $yearOffset >= 0; $yearOffset--) {
                $year = date('Y') - $yearOffset;
                $total = Pembelian::where('nama_supplier', $supplier)
                                 ->whereYear('tanggal', $year)
                                 ->sum('grand_total');
                $yearlyData[] = $total;
            }

            $datasets[] = [
                'label' => $supplier,
                'data' => $yearlyData,
                'borderColor' => $colors[$i % count($colors)],
                'backgroundColor' => $colors[$i % count($colors)] . '20',
                'tension' => 0.4,
                'fill' => false
            ];
            $i++;
        }

        return $datasets;
    }

    private function getSummaryStats()
    {
        $totalPurchases = Pembelian::sum('grand_total');
        $totalTransactions = Pembelian::count();
        $averagePurchase = $totalTransactions > 0 ? $totalPurchases / $totalTransactions : 0;

        // Get top supplier
        $topSupplier = Pembelian::select('nama_supplier')
                               ->selectRaw('SUM(grand_total) as total')
                               ->groupBy('nama_supplier')
                               ->orderBy('total', 'desc')
                               ->first();

        return [
            'total_purchases' => $totalPurchases,
            'total_transactions' => $totalTransactions,
            'average_purchase' => $averagePurchase,
            'top_supplier' => $topSupplier ? $topSupplier->nama_supplier : 'N/A',
            'top_supplier_total' => $topSupplier ? $topSupplier->total : 0
        ];
    }

    public function getChartDataApi(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $chartData = $this->getChartData($period);

        return response()->json($chartData);
    }
}
