<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class RunModelsInPythonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commodityPath;

    public $populationPath;

    public $cropId;

    public $conversionRate;

    public $cropType;

    public $population;

    public $populationYear;

    public $perCapita;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($commodityPath,
                                $populationPath,
                                $cropId,
                                $conversionRate,
                                $cropType,
                                $population,
                                $populationYear,
                                $perCapita)
    {
        $this->commodityPath = $commodityPath;
        $this->populationPath = $populationPath;
        $this->cropId = $cropId;
        $this->conversionRate = $conversionRate;
        $this->cropType = $cropType;
        $this->population = $population;
        $this->populationYear = $populationYear;
        $this->perCapita = $perCapita;
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle()
    {
        $url = config('nfcqs.PYTHON_APP');

        $file1 = fopen($this->commodityPath, 'r');
        $file2 = fopen($this->populationPath, 'r');

        $response = Http::attach('commodity_data', $file1)
            ->attach('population_data', $file2)->post($url, [
                'crop_id' => $this->cropId,
                'conversion_rate' => $this->conversionRate,
                'crop_type' => $this->cropType,
                'population' => $this->population,
                'population_year' => $this->populationYear,
                'per_capita' => $this->perCapita,
            ]);

        return 0;
    }
}
