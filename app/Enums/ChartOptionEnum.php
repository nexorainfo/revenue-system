<?php

namespace App\Enums;

enum ChartOptionEnum: string
{
    case BAR_CHART = 'bar chart';
    case PIE_CHART = 'pie chart';
    case DOUGHNUT_CHART = 'doughnut chart';
    case HORIZONTAL_BAR_CHART = 'horizontal bar chart';
    case LINE_CHART = 'line chart';
    case POLAR_AREA_CHART = 'polar area chart';
    case STEPPED_LINE_CHART = 'stepped line chart';
    case BUBBLE_CHART = 'bubble chart';

    public function option(): array
    {
        return self::getOption($this);
    }

    public static function getOption(self $value): array
    {
        return match ($value) {
            self::BAR_CHART, self::LINE_CHART => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ],
            ],
            self::PIE_CHART, self::DOUGHNUT_CHART, self::POLAR_AREA_CHART => [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ],
            self::HORIZONTAL_BAR_CHART => [
                'responsive' => true,
                'maintainAspectRatio' => true,
                'indexAxis' => 'y',
            ],
            self::STEPPED_LINE_CHART => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ],
                'axis' => 'x',
            ],
            self::BUBBLE_CHART => [
                'scales' => [
                    'x' => [
                        'type' => 'category',
                        'beginAtZero' => true,
                    ],
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ],
            ],
        };
    }
}
