<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CategoryExport implements  FromView
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     $categories = Category::query()->get();

    //     return $categories;
    // }

    public function view(): View
    {
        $categories = Category::query();
        $this->request = request('name', '');

        if (!empty($this->request) || $this->request == 0) {
            $categories = $categories->where('name', 'like', '%' . $this->request . '%');
        }
        $categories = $categories->get();
        return view('admin.categories.export', [
            'categories' => $categories,
        ]);
    }
}
