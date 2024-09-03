<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAllCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar todas las caches a la vez';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('route:clear');
        $this->call('route:cache');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('event:clear');

        $this->info('¡Todas las cachés han sido limpiadas con éxito!');

        return 0;
    }
}
