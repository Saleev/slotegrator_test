<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendMoney;

class SendMoneyCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Данная команда отправляет денежные средства на счет клиента выставляя их в очередь';

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
     * @return int
     */
    public function handle()
    {
        SendMoney::dispatch();
        return 0;
    }
}
