<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Jobs\ProcessPodcast;
use App\Mail\TestMail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

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
}
