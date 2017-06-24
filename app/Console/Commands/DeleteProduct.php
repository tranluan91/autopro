<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Automattic\WooCommerce\Client;

class DeleteProduct extends Command
{
    const consumer_key = 'ck_468c6beedd1adb3c19fa56d86cc1673dba2348c7';
    const consumer_secret = 'cs_2e4ae77a81d42d14488ba34d0ba782fe7240a713';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete product with empty images';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $client;

    protected $limit = 50;

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
        set_time_limit(0);
        try {
            $this->client = new Client($this->argument('domain'), self::consumer_key, self::consumer_secret, ['timeout' => 200]);
            $this->deleteProduct();
        } catch (\Exception $e) {
            \Log::alert($e);
        }

        return false;
    }

    public function countProduct()
    {
        $count = $this->client->get('products/count');

        if (isset($count['count'])) {
            return $count['count'];
        }

        return 0;
    }

    public function deleteProduct()
    {
        $total = $this->countProduct();
        $countFor = round($total / $this->limit) + 1;

        for ($i = 0; $i < $countFor; $i++) {
            $products = $this->client->get('products', [
                'filter[limit]' => $this->limit,
                'filter[offset]' => $this->limit * $i,
                'fields' => 'id,images',
            ]);

            foreach ($products['products'] as $product) {
                if (isset($product['id']) && empty($product['images'])) {
                    $this->client->delete('products/' . $product['id'], ['force' => true]);
                }
            }
        }
    }
}
