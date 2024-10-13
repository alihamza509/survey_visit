<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class ExpenseController extends Controller
{
    public function index()
    {
        // Get all expenses along with the user information
        $expenses = Expense::with('user')->get();

        return view('admin.expense.index', compact('expenses'));
    }

    public function export()
    {
        // Fetch all expenses data
        $expenses = Expense::with('user')->get();

        // Create a new spreadsheet and set the header row
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Date of Expense');
        $sheet->setCellValue('D1', 'Expense Detail');

        // Populate spreadsheet with expense data
        $rowNumber = 2; // Starting row
        foreach ($expenses as $expense) {
            $sheet->setCellValue('A' . $rowNumber, $expense->id);
            $sheet->setCellValue('B' . $rowNumber, $expense->user->name);
            $sheet->setCellValue('C' . $rowNumber, $expense->date_of_expense);
            $sheet->setCellValue('D' . $rowNumber, $expense->expense_detail);
            $rowNumber++;
        }

        // Save the file to a temporary location
        $filename = "expenses_" . now()->format('Ymd_His') . ".xlsx";
        $tempFilePath = sys_get_temp_dir() . '/' . $filename;
        $writer = new WriterXlsx($spreadsheet);
        $writer->save($tempFilePath);

        // Return the file as a download response
        return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
    }
    public function show($id)
    {
        $expense = Expense::with('user')->findOrFail($id);

        return view('admin.expense.show', compact('expense'));
    }
}
