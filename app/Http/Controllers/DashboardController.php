<?php

namespace App\Http\Controllers;

use App\Models\order_header;
use App\Models\order_lines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the total quantity of orders created today
        $totalOrdersToday = order_lines::getTotalOrdersToday();

        // Get the total sales for today
        $totalSalesToday = order_header::getTotalSalesToday();

        // Get the number of orders placed by customers today
        $ordersCountToday = order_header::getOrdersCountToday();

        // Get daily data for total orders, total sales, and customer count
        $dailyOrders = $this->getDailyData('quantity');
        $dailySales = $this->getDailyData('total');
        $dailyCustomers = $this->getDailyCustomers();


        // Get the monthly data for total orders, total sales, and customer count
        $monthlyOrders = $this->getMonthlyData('quantity');
        $monthlySales = $this->getMonthlyData('total'); // assuming 'total' is the sales field in `order_lines`
        $monthlyCustomers = $this->getMonthlyCustomers();

        // Yearly Data (aggregate over the whole year)
        $yearlyOrders = $this->getYearlyOrders();
        $yearlySales = $this->getYearlySales();
        $yearlyCustomers = $this->getYearlyCustomers();

        // Pass the data to the view
        return view('pages.dashboard.dashboard', compact('totalOrdersToday', 'totalSalesToday', 'ordersCountToday', 'dailyOrders', 'dailySales', 'dailyCustomers', 'monthlyOrders', 'monthlySales', 'monthlyCustomers', 'yearlyOrders', 'yearlySales', 'yearlyCustomers'));
    }

    // Get daily data for orders, sales, or other metrics
    private function getDailyData($field)
    {
        return order_header::join('order_lines', 'order_lines.order_header_id', '=', 'order_headers.id')
            ->selectRaw("DAY(order_headers.order_date) as day, SUM(order_lines.$field) as total")
            ->whereYear('order_headers.order_date', date('Y')) // Filter for the current year
            ->whereMonth('order_headers.order_date', date('m')) // Filter for the current month
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('total', 'day');
    }

    // Get daily customer count
    private function getDailyCustomers()
    {
        return order_header::selectRaw("DAY(order_date) as day, COUNT(DISTINCT user_id) as total")
            ->whereYear('order_date', date('Y')) // Filter for the current year
            ->whereMonth('order_date', date('m')) // Filter for the current month
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('total', 'day');
    }

    // Get monthly data for orders, sales, or other metrics
    private function getMonthlyData($field)
    {
        return order_header::join('order_lines', 'order_lines.order_header_id', '=', 'order_headers.id')
            ->selectRaw("MONTH(order_headers.order_date) as month, SUM(order_lines.$field) as total")
            ->whereYear('order_headers.order_date', date('Y')) // Filter for the current year
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');
    }

    // Get monthly customer count
    private function getMonthlyCustomers()
    {
        return order_header::selectRaw("MONTH(order_date) as month, COUNT(DISTINCT user_id) as total")
            ->whereYear('order_date', date('Y')) // Filter for the current year
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');
    }

    // Get yearly order quantity
    private function getYearlyOrders()
    {
        return order_header::join('order_lines', 'order_headers.id', '=', 'order_lines.order_header_id')
            ->selectRaw('YEAR(order_headers.order_date) as year, SUM(order_lines.quantity) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
    }

    // Get yearly sales (total amount)
    private function getYearlySales()
    {
        return order_header::join('order_lines', 'order_headers.id', '=', 'order_lines.order_header_id')
            ->selectRaw('YEAR(order_headers.order_date) as year, SUM(order_lines.total) as total') // assuming 'total' is the sales field in `order_lines`
            ->groupBy('year')
            ->orderBy('year')
            ->get();
    }

    // Get yearly customer count
    private function getYearlyCustomers()
    {
        return order_header::selectRaw('YEAR(order_date) as year, COUNT(DISTINCT user_id) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
    }
}
