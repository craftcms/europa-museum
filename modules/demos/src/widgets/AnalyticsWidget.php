<?php

namespace modules\demos\widgets;

use Craft;
use craft\base\Widget;
use craft\helpers\Cp;
use craft\helpers\Html;
use craft\helpers\StringHelper;
use craft\web\View;

class AnalyticsWidget extends Widget
{
    public ?string $name = null;

    public string $type = 'bar';

    public static function displayName(): string
    {
        return Craft::t('site', 'Analytics Widget');
    }

    public function getTitle(): ?string
    {
        return $this->name ?? parent::getTitle();
    }

    public function getBodyHtml(): ?string
    {
        Craft::$app->getView()->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js', ['position' => \craft\web\View::POS_END]);

        $id = 'analytics-widget-' . $this->id;

        $js = $this->_renderChartJs($id);
        if (!$js) {
            return Html::tag('div', rand(34, 124), [
                'style' => 'font-size: 5rem; text-align: center; padding: 3rem 0; font-weight: bold;',
            ]);
        }

        Craft::$app->getView()->registerJs($js, View::POS_END);

        return Html::tag('div',
            Html::tag('canvas', '', ['id' => $id])
        );
    }

    private function _renderChartJs(string $id): string
    {
        $label = Html::encode($this->name);

        return match ($this->type) {
            'number' => '',
            'doughnut' => <<<JS
                    new Chart(
                        document.getElementById('$id'),
                        {
                            type: 'doughnut',
                            data: {
                                labels: [
                                    'Europe',
                                    'Asia',
                                    'North America'
                                ],
                                datasets: [{
                                    data: [300, 50, 100],
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)'
                                    ],
                                    hoverOffset: 4
                                }]
                            }
                        }
                    )
                    JS,
            default => <<<JS
const data{$this->id} = [
    { year: 2024, count: 22 },
    { year: 2024, count: 22 },
    { year: 2025, count: 30 },
    { year: 2026, count: 1 },
  ];

new Chart(
    document.getElementById('$id'),
    {
      type: 'bar',
      data: {
        labels: data{$this->id}.map(row => row.year),
        datasets: [
          {
            label: '$label by year (in thousands)',
            data: data{$this->id}.map(row => row.count)
          }
        ]
      }
    }
)
JS,
        };
    }

    public function getSettingsHtml(): ?string
    {
        return Cp::textFieldHtml([
            'label' => Craft::t('site', 'Name'),
            'name' => 'name',
            'value' => $this->name,
        ]) .

        Cp::selectFieldHtml([
            'label' => Craft::t('site', 'Type'),
            'name' => 'type',
            'value' => $this->type,
            'options' => [
                ['label' => Craft::t('site', 'Bar'), 'value' => 'bar'],
                ['label' => Craft::t('site', 'Doughnut'), 'value' => 'doughnut'],
                ['label' => Craft::t('site', 'Number'), 'value' => 'number'],
            ],
        ])
            ;
    }
}
