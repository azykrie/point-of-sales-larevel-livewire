<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\Attributes\Title;


#[Title("Dashboard")]
class Index extends Component
{
    public array $myChart = [
        'type' => 'bar',
        'data' => [
            'labels' => ['Mary', 'Joe', 'Ana'],
            'datasets' => [
                [
                    'label' => '# of Votes',
                    'data' => [12, 19, 3],
                ]
            ]
        ]
    ];

    public function randomize()
    {
        Arr::set($this->myChart, 'data.datasets.0.data', [fake()->randomNumber(2), fake()->randomNumber(2), fake()->randomNumber(2)]);
    }

    public function switch()
    {
        $type = $this->myChart['type'] == 'bar' ? 'pie' : 'bar';
        Arr::set($this->myChart, 'type', $type);
    }
    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
