<?php

namespace App\Jobs;

use App\Helpers\OnMoneySend;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMoney implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1; //Кол-во неудачных попыток

    protected $prizes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Находим все не отправленные деньги
        $this->prizes = OnMoneySend::money();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->prizes) {
            //Сюда надо какую то поставить операцию которая будет отправлять на счет деньги
            info("Отправленна сумма ".$this->prizes->money." на карту ".$this->prizes->card_num);
            //Делаем обновление записи в талице ставим статус отправлен
            OnMoneySend::SaveSendMoney($this->prizes->id_prize);
        }
    }

    public function failed(Exception $exception)
    {
        info(__CLASS__." Ошибка отправки ".$exception->getMessage());
    }
}
