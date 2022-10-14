<?php

namespace App\Console\Commands;

use App\Models\Materias\RedatorAleatorio;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RefreshMaterias extends Command
{

    protected $signature = 'refresh_materias';
    protected $description = 'RefreshMaterias';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        RedatorAleatorio::whereRaw("coalesce(status,0) == 3")
            ->whereRaw("DATEDIFF(DAY, data_leitura, GETDATE()) > 3")
            ->update([
                'status' => 0,
                'usuario_id' => 0,
                'data_leitura' => null,
            ]);
    }
}
