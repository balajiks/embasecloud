<?php

namespace Modules\Analytics\Console;

use Illuminate\Console\Command;
use Modules\Indexing\Entities\Indexing;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ComputeIndexing extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'analytics:indexing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to calculate indexing reports.';

    /**
     * Indexing model
     *
     * @var \Modules\Indexing\Entities\Indexing
     */
    protected $indexing;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Indexing $indexing)
    {
        parent::__construct();
        $this->indexing = $indexing;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->total();
        $this->indexingValue();
        $this->converted();
        $this->indexingToday();
        $this->indexingThisWeek();
        $this->thisMonth();
        $this->lastMonth();
        $this->calcQuaters();
        $this->info('Indexing reports calculated successfully');
    }

    protected function total()
    {
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_total'],
            ['value' => $this->indexing->count()]
        );
    }

    protected function indexingValue()
    {
        $amount = 0;
        $this->indexing->chunk(
            200,
            function ($indexing) use (&$amount) {
                foreach ($indexing as $key => $indexing) {
                    $amount += $indexing->indexing_value;
                };
            }
        );
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_value'],
            ['value' => $amount]
        );
    }

    protected function converted()
    {
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_converted'],
            ['value' => $this->indexing->converted()->count()]
        );
    }

    protected function indexingToday()
    {
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_today'],
            ['value' => $this->indexing->whereDate('created_at', today())->count()]
        );
    }

    protected function indexingThisWeek()
    {
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_this_week'],
            ['value' => $this->indexing->whereBetween('created_at', [now()->startOfWeek(),now()->endOfWeek()])->count()]
        );
    }

    protected function thisMonth()
    {
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_this_month'],
            ['value' => $this->indexing->whereYear('created_at', now()->format('Y'))->whereMonth('created_at', now()->format('n'))->count()]
        );
    }

    protected function lastMonth()
    {
        $dt = now()->subMonth(1);
        \App\Entities\Computed::updateOrCreate(
            ['key' => 'indexing_last_month'],
            ['value' => $this->indexing->whereYear('created_at', $dt->format('Y'))->whereMonth('created_at', $dt->format('n'))->count()]
        );
    }
    protected function calcQuaters()
    {
        $year = chartYear();
        for ($i = 1; $i < 13; $i++) {
            \App\Entities\Computed::updateOrCreate(
                ['key' => 'indexing_'.$i.'_'.$year],
                ['value' => $this->indexing->whereYear('created_at', $year)->whereMonth('created_at', (string)$i)->count()]
            );
        }
    }
}
