<?php

namespace App\Console\Commands;

use App\Repositories\ProdRepo;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class UpdateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:update {id} {--name=} {--description=} {--price=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a product as id with options below';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $prodRepo = new ProdRepo();
        $options = $prodRepo->chkUpdateOpts($this->options());
        $error = Arr::get($options, 'error', '');
        if ($error) {
            $this->error($error);
            return 0;
        }

        $id = (int)($this->argument('id'));
        $error = $prodRepo->updateProduct($id, $options);
        if ($error) {
            $this->error($error);
            return 0;
        }
        $this->info("Price change notification dispatched to " .
            config('PRICE_NOTIFICATION_EMAIL', 'admin@example.com'));
        return 0;
    }
}
