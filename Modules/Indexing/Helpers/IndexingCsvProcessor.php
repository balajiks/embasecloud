<?php

namespace Modules\Indexing\Helpers;

use Modules\Indexing\Entities\Indexing;

class IndexingCsvProcessor
{
    /**
     * Import indexing from CSV.
     */
    public function import(\Illuminate\Http\Request $request)
    {
        $data = \App\Entities\CsvData::findOrFail($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $column = [];
            foreach ($request->fields as $csvfield => $dbfield) {
                if (!is_null($dbfield)) {
                    if (in_array($dbfield, config('db-fields.indexing'))) {
                        $column[$dbfield] = $row[$csvfield];
                    }
                }
            }
            Indexing::firstOrCreate(['email' => $column['email']], $column);
        }
    }
}
