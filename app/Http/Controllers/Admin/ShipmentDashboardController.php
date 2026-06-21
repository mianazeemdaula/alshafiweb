<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\CourierServiceConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShipmentDashboardController extends Controller
{
    /**
     * Display the shipment dashboard
     */
    public function index()
    {
        // Get date ranges
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // Key Performance Indicators
        $kpis = $this->getKPIs($today, $thisWeek, $thisMonth);
        
        // Status distribution
        $statusDistribution = $this->getStatusDistribution();
        
        // Courier performance
        $courierPerformance = $this->getCourierPerformance();
        
        // Daily shipments trend (last 30 days)
        $dailyTrend = $this->getDailyShipmentsTrend();
        
        // Weekly performance comparison
        $weeklyComparison = $this->getWeeklyComparison();
        
        // Recent shipments
        $recentShipments = $this->getRecentShipments();
        
        // Revenue analytics
        $revenueAnalytics = $this->getRevenueAnalytics();
        
        // Delivery performance by city
        $cityPerformance = $this->getCityPerformance();
        
        // Active couriers
        $activeCouriers = CourierServiceConfig::where('is_active', true)->get();

        return view('admin.dashboard.shipments', compact(
            'kpis',
            'statusDistribution',
            'courierPerformance',
            'dailyTrend',
            'weeklyComparison',
            'recentShipments',
            'revenueAnalytics',
            'cityPerformance',
            'activeCouriers'
        ));
    }

    /**
     * Get real-time dashboard data for AJAX updates
     */
    public function getData(Request $request)
    {
        $type = $request->get('type', 'overview');
        
        switch ($type) {
            case 'overview':
                return response()->json([
                    'kpis' => $this->getKPIs(Carbon::today(), Carbon::now()->startOfWeek(), Carbon::now()->startOfMonth()),
                    'statusDistribution' => $this->getStatusDistribution(),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ]);
                
            case 'trends':
                return response()->json([
                    'dailyTrend' => $this->getDailyShipmentsTrend(),
                    'weeklyComparison' => $this->getWeeklyComparison(),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ]);
                
            case 'couriers':
                return response()->json([
                    'courierPerformance' => $this->getCourierPerformance(),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ]);
                
            case 'revenue':
                return response()->json([
                    'revenueAnalytics' => $this->getRevenueAnalytics(),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ]);
                
            default:
                return response()->json(['error' => 'Invalid data type'], 400);
        }
    }

    /**
     * Get Key Performance Indicators
     */
    private function getKPIs($today, $thisWeek, $thisMonth)
    {
        return [
            'total_shipments' => [
                'value' => Shipment::count(),
                'today' => Shipment::whereDate('created_at', $today)->count(),
                'week' => Shipment::where('created_at', '>=', $thisWeek)->count(),
                'month' => Shipment::where('created_at', '>=', $thisMonth)->count(),
                'growth' => $this->calculateGrowth('shipments', $thisMonth)
            ],
            'delivered' => [
                'value' => Shipment::where('status', 'delivered')->count(),
                'today' => Shipment::where('status', 'delivered')->whereDate('updated_at', $today)->count(),
                'week' => Shipment::where('status', 'delivered')->where('updated_at', '>=', $thisWeek)->count(),
                'month' => Shipment::where('status', 'delivered')->where('updated_at', '>=', $thisMonth)->count(),
                'growth' => $this->calculateGrowth('delivered', $thisMonth)
            ],
            'pending' => [
                'value' => Shipment::whereIn('status', ['pending', 'processing', 'shipped'])->count(),
                'today' => Shipment::whereIn('status', ['pending', 'processing', 'shipped'])->whereDate('created_at', $today)->count(),
                'week' => Shipment::whereIn('status', ['pending', 'processing', 'shipped'])->where('created_at', '>=', $thisWeek)->count()
            ],
            'delivery_rate' => [
                'value' => $this->calculateDeliveryRate(),
                'week' => $this->calculateDeliveryRate($thisWeek),
                'month' => $this->calculateDeliveryRate($thisMonth)
            ],
            'avg_delivery_time' => [
                'value' => $this->calculateAverageDeliveryTime(),
                'week' => $this->calculateAverageDeliveryTime($thisWeek),
                'month' => $this->calculateAverageDeliveryTime($thisMonth)
            ],
            'revenue' => [
                'total' => $this->getTotalRevenue(),
                'today' => $this->getTotalRevenue($today),
                'week' => $this->getTotalRevenue($thisWeek),
                'month' => $this->getTotalRevenue($thisMonth),
                'growth' => $this->calculateGrowth('revenue', $thisMonth)
            ]
        ];
    }

    /**
     * Get status distribution
     */
    private function getStatusDistribution()
    {
        return Shipment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [ucfirst(str_replace('_', ' ', $item->status)) => $item->count];
            })
            ->toArray();
    }

    /**
     * Get courier performance
     */
    private function getCourierPerformance()
    {
        return Shipment::join('courier_service_configs', 'shipments.courier_service_config_id', '=', 'courier_service_configs.id')
            ->select(
                'courier_service_configs.courier',
                DB::raw('count(*) as total_shipments'),
                DB::raw('sum(case when shipments.status = "delivered" then 1 else 0 end) as delivered'),
                DB::raw('sum(case when shipments.status in ("cancelled", "returned") then 1 else 0 end) as failed'),
                DB::raw('avg(case when shipments.status = "delivered" then DATEDIFF(shipments.updated_at, shipments.created_at) else null end) as avg_delivery_days'),
                DB::raw('sum(shipments.cod_amount) as total_revenue')
            )
            ->groupBy('courier_service_configs.courier')
            ->get()
            ->map(function ($item) {
                $item->delivery_rate = $item->total_shipments > 0 ? round(($item->delivered / $item->total_shipments) * 100, 2) : 0;
                $item->avg_delivery_days = round($item->avg_delivery_days ?? 0, 1);
                return $item;
            });
    }

    /**
     * Get daily shipments trend (last 30 days)
     */
    private function getDailyShipmentsTrend()
    {
        $days = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days->push([
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('M j'),
                'shipments' => Shipment::whereDate('created_at', $date)->count(),
                'delivered' => Shipment::where('status', 'delivered')->whereDate('updated_at', $date)->count(),
                'revenue' => Shipment::whereDate('created_at', $date)->sum('cod_amount')
            ]);
        }
        return $days;
    }

    /**
     * Get weekly comparison (current vs previous week)
     */
    private function getWeeklyComparison()
    {
        $currentWeek = Carbon::now()->startOfWeek();
        $previousWeek = Carbon::now()->subWeek()->startOfWeek();
        
        $current = [
            'shipments' => Shipment::where('created_at', '>=', $currentWeek)->count(),
            'delivered' => Shipment::where('status', 'delivered')->where('updated_at', '>=', $currentWeek)->count(),
            'revenue' => Shipment::where('created_at', '>=', $currentWeek)->sum('cod_amount')
        ];
        
        $previous = [
            'shipments' => Shipment::whereBetween('created_at', [$previousWeek, $currentWeek])->count(),
            'delivered' => Shipment::where('status', 'delivered')->whereBetween('updated_at', [$previousWeek, $currentWeek])->count(),
            'revenue' => Shipment::whereBetween('created_at', [$previousWeek, $currentWeek])->sum('cod_amount')
        ];
        
        return [
            'current' => $current,
            'previous' => $previous,
            'growth' => [
                'shipments' => $this->calculatePercentageChange($previous['shipments'], $current['shipments']),
                'delivered' => $this->calculatePercentageChange($previous['delivered'], $current['delivered']),
                'revenue' => $this->calculatePercentageChange($previous['revenue'], $current['revenue'])
            ]
        ];
    }

    /**
     * Get recent shipments
     */
    private function getRecentShipments()
    {
        return Shipment::with(['order.user', 'courierService'])
            ->latest()
            ->limit(10)
            ->get();
    }

    /**
     * Get revenue analytics
     */
    private function getRevenueAnalytics()
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        return [
            'monthly_revenue' => Shipment::where('created_at', '>=', $thisMonth)->sum('cod_amount'),
            'monthly_growth' => $this->calculateGrowth('revenue', $thisMonth),
            'avg_order_value' => Shipment::avg('cod_amount'),
            'total_cod_collected' => Shipment::where('status', 'delivered')->sum('cod_amount'),
            'pending_collection' => Shipment::whereIn('status', ['pending', 'processing', 'shipped'])->sum('cod_amount'),
            'courier_revenue' => $this->getCourierRevenue()
        ];
    }

    /**
     * Get city performance
     */
    private function getCityPerformance()
    {
        return Shipment::join('orders', 'shipments.order_id', '=', 'orders.id')
            ->join('cities', 'orders.city_id', '=', 'cities.id')
            ->select(
                'cities.name as city_name',
                DB::raw('count(*) as total_shipments'),
                DB::raw('sum(case when shipments.status = "delivered" then 1 else 0 end) as delivered'),
                DB::raw('avg(case when shipments.status = "delivered" then DATEDIFF(shipments.updated_at, shipments.created_at) else null end) as avg_delivery_days')
            )
            ->groupBy('cities.id', 'cities.name')
            ->orderByDesc('total_shipments')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->delivery_rate = $item->total_shipments > 0 ? round(($item->delivered / $item->total_shipments) * 100, 2) : 0;
                $item->avg_delivery_days = round($item->avg_delivery_days ?? 0, 1);
                return $item;
            });
    }

    /**
     * Helper methods
     */
    private function calculateGrowth($type, $fromDate)
    {
        $currentPeriod = null;
        $previousPeriod = null;
        
        switch ($type) {
            case 'shipments':
                $currentPeriod = Shipment::where('created_at', '>=', $fromDate)->count();
                $previousPeriod = Shipment::whereBetween('created_at', [
                    $fromDate->copy()->subMonth(), 
                    $fromDate
                ])->count();
                break;
                
            case 'delivered':
                $currentPeriod = Shipment::where('status', 'delivered')->where('updated_at', '>=', $fromDate)->count();
                $previousPeriod = Shipment::where('status', 'delivered')->whereBetween('updated_at', [
                    $fromDate->copy()->subMonth(), 
                    $fromDate
                ])->count();
                break;
                
            case 'revenue':
                $currentPeriod = Shipment::where('created_at', '>=', $fromDate)->sum('cod_amount');
                $previousPeriod = Shipment::whereBetween('created_at', [
                    $fromDate->copy()->subMonth(), 
                    $fromDate
                ])->sum('cod_amount');
                break;
        }
        
        return $this->calculatePercentageChange($previousPeriod, $currentPeriod);
    }

    private function calculatePercentageChange($old, $new)
    {
        if ($old == 0) return $new > 0 ? 100 : 0;
        return round((($new - $old) / $old) * 100, 2);
    }

    private function calculateDeliveryRate($fromDate = null)
    {
        $query = Shipment::query();
        if ($fromDate) {
            $query->where('created_at', '>=', $fromDate);
        }
        
        $total = $query->count();
        $delivered = $query->where('status', 'delivered')->count();
        
        return $total > 0 ? round(($delivered / $total) * 100, 2) : 0;
    }

    private function calculateAverageDeliveryTime($fromDate = null)
    {
        $query = Shipment::where('status', 'delivered');
        if ($fromDate) {
            $query->where('updated_at', '>=', $fromDate);
        }
        
        $avgDays = $query->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')->value('avg_days');
        
        return round($avgDays ?? 0, 1);
    }

    private function getTotalRevenue($fromDate = null)
    {
        $query = Shipment::query();
        if ($fromDate) {
            $query->where('created_at', '>=', $fromDate);
        }
        
        return $query->sum('cod_amount');
    }

    private function getCourierRevenue()
    {
        return Shipment::join('courier_service_configs', 'shipments.courier_service_config_id', '=', 'courier_service_configs.id')
            ->select(
                'courier_service_configs.courier',
                DB::raw('sum(shipments.cod_amount) as revenue'),
                DB::raw('count(*) as shipments')
            )
            ->groupBy('courier_service_configs.courier')
            ->get();
    }
}