<?php

namespace App\Jobs;

use App\Mail\TestMail;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $log = new Logger('Test thoi nha');
        $category = Category::query()->get();
        if (empty($category)) {
            Log::channel('daily')->info('No data');
            return;
        }
        Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/Test_thoi_nha' ). '.log',
        ])->info('Success');
        $mail = 'tong.van.dung@vinicorp.com.vn';
        Mail::to($mail)->send(new TestMail($category));
    }
}
