<?php

namespace ConsoleTVs\Charts\Classes\Chartjs;

use ConsoleTVs\Charts\Classes\BaseChart;
use ConsoleTVs\Charts\Features\Chartjs\Chart as ChartFeatures;

class Chart extends BaseChart
{
    use ChartFeatures;

    /**
     * Chartjs dataset class.
     *
     * @var object
     */
    public $dataset = Dataset::class;

    /**
     * costum anchor
     *
     * @var boolean
     */
    public $costumAnchor = false;

    /**
     * Minimum Conditional anchor value
     *
     * @var int
     */
    public $minConditionalAnchor = 0;

    /**
     * position anchor
     *
     * @var array
     */
    public $positionAnchor = ['end', 'center'];

    /**
     * color anchor
     *
     * @var array
     */
    public $colorAnchor = ['#000', '#fff'];


    /**
     * Initiates the Chartjs Line Chart.
     *
     * @return self
     */
    public function __construct()
    {
        parent::__construct();

        $this->container = 'charts::chartjs.container';
        $this->script = 'charts::chartjs.script';

        return $this->options([
            'maintainAspectRatio' => false,
            'scales'              => [
                'xAxes' => [],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * set use custom anchor
     *
     * @return self
     */
    public function useConstumAnchor(
        bool $active = false,
        int $min = 0,
        array $positionAnchor = null,
        array $colorAnchor = null,
    )
    {
        $this->costumAnchor = $active;
        $this->minConditionalAnchor = $min;
        $this->positionAnchor = $positionAnchor ?? $this->positionAnchor;
        $this->colorAnchor = $colorAnchor ?? $this->colorAnchor;
        return $this;
    }

}
