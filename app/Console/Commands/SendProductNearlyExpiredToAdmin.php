<?php

namespace App\Console\Commands;

use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Notifications\AlmostExpiredProducts;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Notification;

class SendProductNearlyExpiredToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:send-product-nearly-expired-to-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert Admin When Products are almost expired, 1 moths prior.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $month = Carbon::now()->addMonth();
        $data =  ProductBox::whereBetween('exp_date', [Carbon::now(), $month])
                ->WhereYear('exp_date',$month->year)->get();

        $user = InternalAdmin::all();
        Notification::send($user, New AlmostExpiredProducts($data));
    }
}
