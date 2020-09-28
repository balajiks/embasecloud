<?php

namespace Modules\Indexing\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Indexing\Entities\Indexing;

class IndexingExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        return view(
            'indexing::exports.indexing', [
            'indexing' => Indexing::orderBy('id', 'desc')->get(),
            ]
        );
    }
}
