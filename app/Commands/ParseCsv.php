<?php

namespace App\Commands;

use App\HomeownerNameParser;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ParseCsv extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'parse-csv {filename : The location of the CSV file (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Take a CSV of homeowner names and parse it into an array of homeowner names';

    /**
     * Execute the console command.
     *
     * @param  \App\HomeownerNameParser  $parser
     * @return mixed
     */
    public function handle(HomeownerNameParser $parser)
    {
        if (!File::exists($filename = $this->argument('filename'))) {
            $this->error("File does not exist at path '{$filename}'");
        }

        $file = File::get($filename);

        $csv_content = str_getcsv($file);

        $homeowners = array_map(fn(string $row) => trim($row), $csv_content);

        if (strtolower($homeowners[0]) === "homeowner") {
            $homeowners = array_slice($homeowners, 1);
        }

        $parsed_homeowners = array_map(fn(string $homeowner) => $parser->parse($homeowner), $homeowners);

        /**
         * Output the homeowners as JSON
         */
        $this->info(json_encode($parsed_homeowners));
    }
}
