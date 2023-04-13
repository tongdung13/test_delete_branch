<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Jobs\ProcessPodcast;
use App\Mail\TestMail;
use App\Models\AuctionDay;
use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()->get();

        return response()->json([
            'status' => 0,
            'code' => 200,
            'message' => 'success',
            'data' => $categories,
        ]);
    }

    public function indexCms(Request $request)
    {
        $categories = Category::query();
        $name = $request->get('name', '');

        if (!empty($name) || $name == 0) {
            $categories = $categories->where('name', 'like', '%' . $name . '%');
        }
        $categories = $categories->get();
        ProcessPodcast::dispatch()->delay(now()->addMinutes(2));

        return view('admin.categories.index', compact('categories'));
    }

    public function export(Request $request)
    {
        return Excel::download(new CategoryExport($request), 'category.xlsx');
    }

    public function sendMail(Request $request)
    {
        $mail = 'tong.van.dung@vinicorp.com.vn';

        Mail::to($mail)->send(new TestMail($request));
        return redirect()->route('categories.index');
    }

    public function pdf(Request $request)
    {
        return Excel::download(new CategoryExport($request), 'category.pdf', ExcelExcel::DOMPDF);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return view('admin.categories.detail', compact('category'));
    }

    public function demo($title)
    {
        $auctionId = AuctionDay::where('title', $title)->first();
        $user = \Illuminate\Support\Facades\Auth::guard('member')->user();
        $buyer_id = $user->buyer_id;

        $items = Item::with('bidsHistory', 'categories', 'brands', 'auction_day')
            ->select('items.*')
            ->where('items.auction_id', $auctionId->id)
            ->when($buyer_id, function ($q) use ($buyer_id) {
                return $q->where('items.buyer_id', $buyer_id);
            })
            ->whereNull('items.set')
            ->groupBy('items.id')
            ->orderby('items.id', 'ASC')
            ->get();

        $excel = new Xlsx();
        $dir = '/download/';
        $path = public_path() . $dir . 'download-01.xlsx';
        $spreadSheet = $excel->load($path);
        $workSheet = $spreadSheet->getActiveSheet();

        $numRow = 4;
        foreach ($items as $key => $item) {
            $workSheet->insertNewRowBefore($numRow);
            // $workSheet->getRowDimension($numRow)->setRowHeight(30); //

            $workSheet->getCell("A" . $numRow)->setValue($item->categories['title']);
            $workSheet->getCell("B" . $numRow)->setValue((int) head(explode('-', $item->box_branch)));
            $data_branch = explode('-', $item->box_branch);
            /* function explode() remove character ' - ' join between 2 numbers and save in an array */
            $workSheet->getCell("C" . $numRow)->setValue((int) end($data_branch));
            $workSheet->getCell("D" . $numRow)->setValue($item->buyer_id);
            $workSheet->getCell("E" . $numRow)->setValue($item->auction_day['title']);
            $workSheet->getCell("F" . $numRow)->setValue($item->brands['title']);
            $cell = $workSheet->getCell("G" . $numRow);
            DataValidationSheet::setValue($cell, PUCH_G::class, $item->auction_day['title']);
            $cell = $workSheet->getCell("H" . $numRow);
            DataValidationSheet::setValue($cell, PUCH_H::class, $item->sex);
            $workSheet->getCell("I" . $numRow)->setValue($item->size);
            $workSheet->getCell("J" . $numRow)->setValue($item->title);
            $workSheet->getCell("K" . $numRow)->setValue($item->designs);
            $workSheet->getCell("L" . $numRow)->setValue($item->auction_day['title']);
            $workSheet->getCell("M" . $numRow)->setValue('');
            $numRow++;
        }

        $workSheet->removeRow($numRow);
        $workSheet->removeRow(3);

        // write and save the file
        $filename = 'Report-items_' . '_' . Carbon::now()->format('d-m-Y') . '.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=$filename ");
        /** @var \PhpOffice\PhpSpreadsheet\Writer\Xlsx $writer */
        $writer = IOFactory::createWriter($spreadSheet, 'Xlsx');
        $writer->setPreCalculateFormulas(false);
        $writer->save('php://output');

        logger()->info('Success to download excel file !');
        return true;
    }

}
