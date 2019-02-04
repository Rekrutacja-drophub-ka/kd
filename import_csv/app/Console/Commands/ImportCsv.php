<?php

namespace App\Console\Commands;

use App\File;
use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:import {--file= : File path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $file_path;
    private $file_extension;
    private $file_name;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->file_path = $this->option('file');

        if (empty($this->file_path)) {
            $this->error('Not enough options (missing: "--file", e.g. --file import_file.csv)');
        } else {
            $file_parts = pathinfo($this->file_path);
            $this->file_extension = $file_parts['extension'];
            $this->file_path = realpath($this->file_path);
            $this->file_name = $file_parts['filename'];

            if ($this->file_extension === 'csv') {
                $this->import_file();
            } else {
                $this->error('File extension is not valid. Please attach .csv file.');
            }
        }
    }

    private function import_file()
    {
        $file_handle = fopen($this->file_path, 'r');
        
        if ($file_handle) {
            $file_rows = $this->get_file_rows($file_handle);
            
            rewind($file_handle);

            $i = 0;
            $imported_records = 0;
            $files_count = File::count();

            $bar = $this->output->createProgressBar($file_rows);
            $bar->start();

            while (($row = fgetcsv($file_handle, 0, ';')) !== FALSE) {
                $mpn = $row[1];
                $quantity = intval($row[6]);
                $production_year = preg_replace("/[^0-9]/", '', $row[7]);
                $price = floatval($row[4]);

                if ($i !== 0) {
                    if ($price > 0 && $quantity > 0 && !empty($mpn) && strlen($production_year) === 4) {
                        $product = new Product([
                            'mpn' => $mpn, 
                            'quantity' => $quantity, 
                            'production_year' => $production_year, 
                            'price' => $price
                        ]);

                        if($product->save()) {
                            $imported_records++;
                        }
                    } else {
                        Storage::append('/import-csv/not_imported_records_'.$files_count.'.csv', implode(';', $row));
                    }
                    $bar->advance();
                } else {
                    Storage::append('/import-csv/not_imported_records_'.$files_count.'.csv', implode(';', $row));
                }

                $i++;
            }
            
            $bar->finish();
            $this->line('');
            fclose($file_handle);

            $file = new File([
                'name' => $this->file_name.'.'.$this->file_extension,
                'records_qty' => $file_rows, 
                'imported_records_qty' => $imported_records
            ]);
            $file->save();
        }
    }

    private function get_file_rows($file_handle)
    {
        $rows = 0;
        while (($row = fgetcsv($file_handle, 0, ';')) !== FALSE) {
            $rows++;
        }

        return $rows - 1;
    }
}
