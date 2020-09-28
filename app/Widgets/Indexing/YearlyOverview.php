<?php

namespace App\Widgets\Indexing;

use Arrilot\Widgets\AbstractWidget;

class YearlyOverview extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $year = chartYear();

        $metrics = new \App\Helpers\Report;
 
        $stats = [
            'jan' => $metrics->indexingByMonth(1, $year),
            'feb' => $metrics->indexingByMonth(2, $year),
            'mar' => $metrics->indexingByMonth(3, $year),
            'apr' => $metrics->indexingByMonth(4, $year),
            'may' => $metrics->indexingByMonth(5, $year),
            'jun' => $metrics->indexingByMonth(6, $year),
            'jul' => $metrics->indexingByMonth(7, $year),
            'aug' => $metrics->indexingByMonth(8, $year),
            'sep' => $metrics->indexingByMonth(9, $year),
            'oct' => $metrics->indexingByMonth(10, $year),
            'nov' => $metrics->indexingByMonth(11, $year),
            'dec' => $metrics->indexingByMonth(12, $year),
        ];

        return view(
            'widgets.indexing.yearly_overview', [
            'config' => $this->config,
            'year' => $year,
            'stats' => $stats,
            ]
        );
    }
}
