<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\ProductVariantAttributeValue;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'activity_log',
            'failed_jobs',
        ]);

        $this->call(AuthSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(ProductBoxSeeder::class);
        $this->call(ProductLotSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductPriceSeeder::class);
        $this->call(ProductVariantSeeder::class);
        $this->call(ProductVariantAttributeSeeder::class);
        $this->call(ProductVariantAttributeValueSeeder::class);
        $this->call(WarehouseSeeder::class);

        Model::reguard();
    }
}
