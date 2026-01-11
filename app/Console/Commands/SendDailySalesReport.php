<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
use App\Mail\DailySalesReportMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today();

        $items = OrderItem::with('product')
            ->whereDate('created_at', $today)
            ->get();

        if ($items->isEmpty()) {
            $this->info('No sales today.');
            return self::SUCCESS;
        }

        $report = $items
            ->groupBy('product_id')
            ->map(function ($group) {
                $product = $group->first()->product;

                return [
                    'product' => $product->name,
                    'quantity' => $group->sum('quantity'),
                    'revenue' => $group->sum(
                        fn ($item) => $item->quantity * $item->price_at_time
                    ),
                ];
            });

        Mail::to('admin@example.com')
            ->send(new DailySalesReportMail($report, $today));

        $this->info('Daily sales report sent.');

        return self::SUCCESS;
    }
}
