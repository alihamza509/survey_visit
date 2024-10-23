<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\FollowUp;
use App\Models\SampleOrder;
use App\Models\SurveyVisit;
use App\Models\TrailOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $surveyVisitCount = SurveyVisit::count();
        $sampleOrderCount = SampleOrder::count();
        $followUpCount = FollowUp::count();
        $trialOrderCount = TrailOrder::count();
        $expenseCount = Expense::count();
    
        // Fetch data for charts
        $monthlySurveyVisits = SurveyVisit::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                   ->groupBy('month')
                                   ->pluck('count', 'month');
        $monthlySampleOrders = SampleOrder::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                   ->groupBy('month')
                                   ->pluck('count', 'month');
        $monthlyFollowUps = FollowUp::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                   ->groupBy('month')
                                   ->pluck('count', 'month');
    
        // Define all months in order
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
        // Initialize arrays for data points
        $surveyVisitData = array_fill(0, 12, 0);
        $sampleOrderData = array_fill(0, 12, 0);
        $followUpData = array_fill(0, 12, 0);
    
        // Map monthly data to respective month
        foreach ($monthlySurveyVisits as $month => $count) {
            $surveyVisitData[$month - 1] = $count; // Subtract 1 to align with zero-based index
        }
        foreach ($monthlySampleOrders as $month => $count) {
            $sampleOrderData[$month - 1] = $count;
        }
        foreach ($monthlyFollowUps as $month => $count) {
            $followUpData[$month - 1] = $count;
        }
    
        return view('admin.dashboard', compact(
            'surveyVisitCount', 
            'sampleOrderCount', 
            'followUpCount', 
            'trialOrderCount', 
            'expenseCount', 
            'surveyVisitData', 
            'sampleOrderData', 
            'followUpData',
            'months'
        ));
    }
}
