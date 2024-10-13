<?php
namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use Illuminate\Http\Request;
use App\Models\SurveyVisit;
use App\Models\Expense;
use App\Models\FollowUp;
use App\Models\SampleOrder;
use App\Models\TrailOrder;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
class SurveyVisitController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'shop_name' => 'required|unique:survey_visits',
                'owner_name' => 'required',
                'owner_phone' => 'required',
                'owner_email' => 'required|email',
                'geo_location' => 'required',
                'comments' => 'required|string',
                'cement_brands' => 'required|string',
                'other_products' => 'required|string',
                'photo_1' => 'required|image|max:2048',
                'photo_2' => 'required|image|max:2048',
                'photo_3' => 'nullable|image|max:2048',
            ]);
    
            $validatedData['user_id'] = Auth::id();
            if ($request->hasFile('photo_1')) {
                $validatedData['photo_1'] = $request->file('photo_1')->store('photos', 'public');
            }
            if ($request->hasFile('photo_2')) {
                $validatedData['photo_2'] = $request->file('photo_2')->store('photos', 'public');
            }
            if ($request->hasFile('photo_3')) {
                $validatedData['photo_3'] = $request->file('photo_3')->store('photos', 'public');
            }
    
            $surveyVisit = SurveyVisit::create($validatedData);
    
            return response()->json([
                'success' => true,
                'message' => 'Survey visit data stored successfully',
                'data' => $surveyVisit,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store survey visit data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getShopNames()
    {
        $shops = SurveyVisit::select('id', 'shop_name', 'owner_name', 'owner_phone', 'owner_email', 'geo_location')->distinct()->get();
        
        return response()->json([
            'success' => true,
            'data' => $shops,
        ]);
    }
    public function expenseStore(Request $request)
    {
        $validatedData = $request->validate([
            'date_of_expense' => 'required|date',
            'invoice_photo' => 'required|image|max:2048',
            'expense_detail' => 'required|string',
        ]);

        try {
            $validatedData['user_id'] = Auth::id();
            if ($request->hasFile('invoice_photo')) {
                $validatedData['invoice_photo'] = $request->file('invoice_photo')->store('invoices', 'public');
            }

            $expense = Expense::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Expense data stored successfully',
                'data' => $expense,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store expense data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeSampleOrder(Request $request)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:survey_visits,id',
            'sample_order' => 'required|string',
            'GST_details' => 'required|string',
            'photo_of_product' => 'required|image|max:2048',
            'comments_of_meeting' => 'required|string',
        ]);

        try {
            $validatedData['user_id'] = Auth::id();
            if ($request->hasFile('photo_of_product')) {
                // Store the uploaded file in the public disk under the 'products' directory
                $validatedData['photo_of_product'] = $request->file('photo_of_product')->store('products', 'public');
            }
        

            $sampleOrder = SampleOrder::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Sample order data stored successfully',
                'data' => $sampleOrder,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store sample order data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function indexSampleOrder()
    {
        try {
            $sampleOrders = SampleOrder::all();

            return response()->json([
                'success' => true,
                'data' => $sampleOrders,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve sample orders',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeFollowUp(Request $request)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:survey_visits,id',
            'photo_display_of_battu' => 'required|image|max:2048',
            'trial_order' => 'required|string',
            'potential_order_horizon' => 'required|date',
            'payment_preference' => 'required',
            'comments_of_meeting' => 'required|string',
        ]);

        try {
            $validatedData['user_id'] = Auth::id();
            
            if ($request->hasFile('photo_display_of_battu')) {
                $validatedData['photo_display_of_battu'] = $request->file('photo_display_of_battu')->store('photos', 'public');
            }

            $followUp = FollowUp::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Follow-up stored successfully',
                'data' => $followUp,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store follow-up',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a listing of the follow-ups.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFollowUp()
    {
        try {
            $followUps = FollowUp::all();

            return response()->json([
                'success' => true,
                'data' => $followUps,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve follow-ups',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeTrailOrder(Request $request)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:survey_visits,id',
            'photo_display_of_battu' => 'required|image|max:2048',
            'types_of_order' => 'required|string',
            'potential_order_horizon' => 'nullable|date',
            'order_quantity' => 'nullable|integer',
            'order_delivery_calendar' => 'nullable|date',
            'meeting_discussion_summary' => 'required|string',
        ]);

        try {
            $validatedData['user_id'] = Auth::id();

            if ($request->hasFile('photo_display_of_battu')) {
                $validatedData['photo_display_of_battu'] = $request->file('photo_display_of_battu')->store('photos', 'public');
            }

            $trailOrder = TrailOrder::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Trail order stored successfully',
                'data' => $trailOrder,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store trail order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexTrailOrder()
    {
        try {
            $trailOrders = TrailOrder::all();

            return response()->json([
                'success' => true,
                'data' => $trailOrders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve trail orders',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
   public function fetchData(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date' => 'required|date',
                'data_name' => 'required|string|in:checkin,survey_visit,sample_order,follow_up,trail_order,expense',
            ]);

            $userId = Auth::id();
            $date = $validatedData['date'];
            $dataName = $validatedData['data_name'];
            $data = [];

            switch ($dataName) {
                case 'checkin':
                    $data = CheckInCheckOut::where('user_id', $userId)
                        ->whereDate('created_at', $date)
                        ->get();
                    break;
                case 'survey_visit':
                    $data = SurveyVisit::where('user_id', $userId)
                        ->whereDate('created_at', $date)
                        ->get();
                    break;
                case 'sample_order':
                    $data = SampleOrder::where('user_id', $userId)
                        ->whereDate('created_at', $date)
                        ->get();
                    break;
                case 'follow_up':
                    $data = FollowUp::where('user_id', $userId)
                        ->whereDate('created_at', $date)
                        ->get();
                    break;
                case 'trail_order':
                    $data = TrailOrder::where('user_id', $userId)
                        ->whereDate('created_at', $date)
                        ->get();
                    break;
                case 'expense':
                    $data = Expense::where('user_id', $userId)
                        ->whereDate('created_at', $date)
                        ->get();
                    break;
                default:
                    throw new Exception('Invalid data name');
            }

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function index()
    {
        // Get all surveys along with the user information
        $surveys = SurveyVisit::with('user')->get();

        return view('admin.survey.index', compact('surveys'));
    }

    public function export()
    {
        // Fetch all surveys data
        $surveys = SurveyVisit::with('user')->get();

        // Create a new spreadsheet and set the header row
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Shop Name');
        $sheet->setCellValue('D1', 'Owner Name');
        $sheet->setCellValue('E1', 'Owner Phone');
        $sheet->setCellValue('F1', 'Owner Email');
        $sheet->setCellValue('G1', 'Geo Location');
        $sheet->setCellValue('H1', 'Comments');
        $sheet->setCellValue('I1', 'Cement Brands');
        $sheet->setCellValue('J1', 'Other Products');

        // Populate spreadsheet with survey data
        $rowNumber = 2; // Starting row
        foreach ($surveys as $survey) {
            $sheet->setCellValue('A' . $rowNumber, $survey->id);
            $sheet->setCellValue('B' . $rowNumber, $survey->user->name);
            $sheet->setCellValue('C' . $rowNumber, $survey->shop_name);
            $sheet->setCellValue('D' . $rowNumber, $survey->owner_name);
            $sheet->setCellValue('E' . $rowNumber, $survey->owner_phone);
            $sheet->setCellValue('F' . $rowNumber, $survey->owner_email);
            $sheet->setCellValue('G' . $rowNumber, $survey->geo_location);
            $sheet->setCellValue('H' . $rowNumber, $survey->comments);
            $sheet->setCellValue('I' . $rowNumber, $survey->cement_brands);
            $sheet->setCellValue('J' . $rowNumber, $survey->other_products);
            $rowNumber++;
        }

        // Save the file to a temporary location
        $filename = "surveys_" . now()->format('Ymd_His') . ".xlsx";
        $tempFilePath = sys_get_temp_dir() . '/' . $filename;
        $writer = new WriterXlsx($spreadsheet);
        $writer->save($tempFilePath);

        // Return the file as a download response
        return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
    }

    public function show($id)
    {
        $survey = SurveyVisit::with('user')->findOrFail($id);

        return view('admin.survey.show', compact('survey'));
    }
    public function indexSample()
    {
        // Get all sample orders
        $sampleOrders = SampleOrder::all();

        return view('admin.sample_orders.index', compact('sampleOrders'));
    }

    public function exportSampleOrder()
    {
        // Fetch all sample orders data
        $sampleOrders = SampleOrder::all();

        // Create a new spreadsheet and set the header row
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Shop ID');
        $sheet->setCellValue('C1', 'Sample Order');
        $sheet->setCellValue('D1', 'GST Details');
        $sheet->setCellValue('E1', 'Photo of Product');
        $sheet->setCellValue('F1', 'Comments of Meeting');

        // Populate spreadsheet with sample order data
        $rowNumber = 2; // Starting row
        foreach ($sampleOrders as $order) {
            $sheet->setCellValue('A' . $rowNumber, $order->id);
            $sheet->setCellValue('B' . $rowNumber, $order->shop_id);
            $sheet->setCellValue('C' . $rowNumber, $order->sample_order);
            $sheet->setCellValue('D' . $rowNumber, $order->GST_details);
            $sheet->setCellValue('E' . $rowNumber, $order->photo_of_product);
            $sheet->setCellValue('F' . $rowNumber, $order->comments_of_meeting);
            $rowNumber++;
        }

        // Save the file to a temporary location
        $filename = "sample_orders_" . now()->format('Ymd_His') . ".xlsx";
        $tempFilePath = sys_get_temp_dir() . '/' . $filename;
        $writer = new Xls($spreadsheet);
        $writer->save($tempFilePath);

        // Return the file as a download response
        return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
    }

    public function showSample($id)
    {
        $sampleOrder = SampleOrder::findOrFail($id);

        return view('admin.sample_orders.show', compact('sampleOrder'));
    }
    public function indexShowFollowup()
    {
        // Get all follow-ups with their associated shop and user information
        $followUps = FollowUp::with(['shop', 'user'])->get();

        return view('admin.follow_up.index', compact('followUps'));
    }

    public function exportFollowup()
    {
        // Fetch all follow-ups data with shop and user information
        $followUps = FollowUp::with(['shop', 'user'])->get();

        // Create a spreadsheet and populate it with follow-up data
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Shop Name');
        $sheet->setCellValue('C1', 'User Name');
        $sheet->setCellValue('D1', 'Photo Display of Battu');
        $sheet->setCellValue('E1', 'Trial Order');
        $sheet->setCellValue('F1', 'Potential Order Horizon');
        $sheet->setCellValue('G1', 'Payment Preference');
        $sheet->setCellValue('H1', 'Comments of Meeting');

        // Populate spreadsheet with follow-up data
        $rowNumber = 2; // Starting row
        foreach ($followUps as $followUp) {
            $sheet->setCellValue('A' . $rowNumber, $followUp->id);
            $sheet->setCellValue('B' . $rowNumber, $followUp->shop->shop_name);
            $sheet->setCellValue('C' . $rowNumber, $followUp->user->name);
            $sheet->setCellValue('D' . $rowNumber, $followUp->photo_display_of_battu);
            $sheet->setCellValue('E' . $rowNumber, $followUp->trial_order);
            $sheet->setCellValue('F' . $rowNumber, $followUp->potential_order_horizon);
            $sheet->setCellValue('G' . $rowNumber, $followUp->payment_preference);
            $sheet->setCellValue('H' . $rowNumber, $followUp->comments_of_meeting);
            $rowNumber++;
        }

        // Save the file to a temporary location
        $filename = "follow_ups_" . now()->format('Ymd_His') . ".xlsx";
        $tempFilePath = sys_get_temp_dir() . '/' . $filename;
        $writer = new WriterXlsx($spreadsheet);
        $writer->save($tempFilePath);

        // Return the file as a download response
        return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
    }

    public function showFollowup($id)
    {
        // Fetch a single follow-up with its associated shop and user information
        $followUp = FollowUp::with(['shop', 'user'])->findOrFail($id);

        return view('admin.follow_up.show', compact('followUp'));
    }
    public function trailorder()
    {
        // Get all trial orders with their associated shop and user information
        $trialOrders = TrailOrder::with(['shop', 'user'])->get();

        return view('admin.trial_order.index', compact('trialOrders'));
    }

    public function exporttrailorder()
    {
        // Fetch all trial orders data with shop and user information
        $trialOrders = TrailOrder::with(['shop', 'user'])->get();

        // Create a spreadsheet and populate it with trial order data
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Shop Name');
        $sheet->setCellValue('C1', 'User Name');
        $sheet->setCellValue('D1', 'Photo Display of Battu');
        $sheet->setCellValue('E1', 'Types of Order');
        $sheet->setCellValue('F1', 'Potential Order Horizon');
        $sheet->setCellValue('G1', 'Order Quantity');
        $sheet->setCellValue('H1', 'Order Delivery Calendar');
        $sheet->setCellValue('I1', 'Meeting Discussion Summary');

        // Populate spreadsheet with trial order data
        $rowNumber = 2; // Starting row
        foreach ($trialOrders as $trialOrder) {
            $sheet->setCellValue('A' . $rowNumber, $trialOrder->id);
            $sheet->setCellValue('B' . $rowNumber, $trialOrder->shop->shop_name);
            $sheet->setCellValue('C' . $rowNumber, $trialOrder->user->name);
            $sheet->setCellValue('D' . $rowNumber, $trialOrder->photo_display_of_battu);
            $sheet->setCellValue('E' . $rowNumber, $trialOrder->types_of_order);
            $sheet->setCellValue('F' . $rowNumber, $trialOrder->potential_order_horizon);
            $sheet->setCellValue('G' . $rowNumber, $trialOrder->order_quantity);
            $sheet->setCellValue('H' . $rowNumber, $trialOrder->order_delivery_calendar);
            $sheet->setCellValue('I' . $rowNumber, $trialOrder->meeting_discussion_summary);
            $rowNumber++;
        }

        // Save the file to a temporary location
        $filename = "trial_orders_" . now()->format('Ymd_His') . ".xlsx";
        $tempFilePath = sys_get_temp_dir() . '/' . $filename;
        $writer = new WriterXlsx($spreadsheet);
        $writer->save($tempFilePath);

        // Return the file as a download response
        return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
    }

    public function showtrailorder($id)
    {
        // Fetch a single trial order with its associated shop and user information
        $trialOrder = TrailOrder::with(['shop', 'user'])->findOrFail($id);

        return view('admin.trial_order.show', compact('trialOrder'));
    }

}
