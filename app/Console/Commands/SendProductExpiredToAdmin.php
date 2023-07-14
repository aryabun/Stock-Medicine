<?php

namespace App\Console\Commands;

use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Notifications\ExpiredProducts;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Notification;

class SendProductExpiredToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:send-product-expired-to-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert Admin that there are expired Products';

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
        $data =  ProductBox::where('exp_date', '<', Carbon::now())->get();
        $notify = InternalAdmin::where('type', 'internal_admin')->get();
        foreach ($notify as $user) {
            Notification::send($user, New ExpiredProducts($data));
        }    
    }
}
