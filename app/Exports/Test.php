<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class Test implements FromCollection, WithHeadings, WithEvents
{

    protected $selects;
    protected $row_count;
    protected $column_count;
    public $auction_id;
    public $buyer_id;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $auctionId = User::where('title', $data)->first();
        $this->auction_id = $auctionId->id;
        $user = Auth::guard('member')->user();
        $this->buyer_id = $user->buyer_id;


        $status = ['active', 'pending', 'disabled'];
        $departments = ['Account', 'Admin', 'Ict', 'Sales'];
        $selects = [
            ['columns_name' => 'G', 'options' => $departments],
            ['columns_name' => 'H', 'options' => $status],
        ];
        $this->selects = $selects;
        $this->row_count = 50; //number of rows that will have the dropdown
        $this->column_count = 5; //number of columns to be auto sized

    }


    public function collection()
    {
        $auction_id = $this->auction_id;
        $buyer_id = $this->buyer_id;

        $items = User::with('bidsHistory', 'categories', 'brands', 'auction_day')
            ->select('items.*')
            ->where('items.auction_id', $auction_id)
            ->when($buyer_id, function ($q) use ($buyer_id) {
                return $q->where('items.buyer_id', $buyer_id);
            })
            ->groupBy('items.id')
            ->orderby('items.id', 'ASC')
            ->get();
        $bidBisory = DB::table('bids_history')->where('auction_id', $this->auction_id)->get();
        foreach ($items as $key => $item) {
            foreach ($bidBisory as $key1 => $value) {
                if ($item->id == $value->item_id) {
                    $items[$key]->amount_original = $value->amount_original;
                    $items[$key]->amount = $value->amount;

                }
            }
        }


        return collect($items);

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()
                    ->getStyle($cellRange)
                    ->applyFromArray($styleArray);


                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }

            },
        ];
    }


    public function headings(): array
    {
        // return [
        //     'オークション No/Auction No.', 'termID', '出品番号/ItemShowCode','元々の指値/ giá gốc','落札希望金額/Giá kỳ vọng', 'スタート価格/Giá khởi điểm',  '出品者ID/ID người show',
        //    '落札ステータス/Status', 'BidPrice', 'BidMemberId',
        //
        // ];
        return [
            [__('ジャンル (必須)'), __('箱番号'), __('枝番号'), __('出品者ID'), __('オークションID(必須)'), __('ブランド情報'), __('分類'), __('性別'), __('サイズ'), __('商品名(必須)'), __('別展'), __('付属品'), __('落札希望価格(必須)(数字型)')],
            ['category', 'box', 'box_branch', 'buyer_id', 'auctionid', 'brands', 'classification', 'sex', 'case_size', 'title', 'description', '', 'sell_price',
            ]
        ];
    }
    public function map($item): array
    {
        //        dd($item->auction_id);
        ini_set('memory_limit', -1);
        set_time_limit(0);
        $category = isset($item->categories['title']) ? ' ' . $item->categories['title'] : '-';
        $box = isset($item->box_branch) ? ' ' . (int) head(explode('-', $item->box_branch)) : '0';
        $data_branch = explode('-', $item->box_branch);
        $box_branch = isset($item->box_branch) ? ' ' . (int) end($data_branch) : '0';
        $buyer_id = isset($item->buyer_id) ? ' ' . $item->buyer_id : '0';
        $auctionid = isset($item->auction_day['title']) ? ' ' . $item->auction_day['title'] : '0';
        $brands = isset($item->brands['title']) ? ' ' . $item->brands['title'] : '-';
        // $classification = '';
        // $sex = '';
        $case_size = isset($item->size) ? $item->size : '-';
        $title = '';
        $designs = isset($item->designs) ? $item->designs : '-';
        $data = '';
        $sell_price = isset($item->sell_price) ? ' ' . $item->sell_price : ' ' . '0';

        return [
            $category,
            $box,
            $box_branch,
            $buyer_id,
            $auctionid,
            $brands,
            '',
            '',
            $case_size,
            $title,
            $designs,
            $data,
            $sell_price
        ];
    }
}
