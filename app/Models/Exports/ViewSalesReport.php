<?php

namespace App\Models\Exports;

use App\Laravel\Models\Participant;
use App\Laravel\Models\Upload;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Str, Helper, Carbon, Mail;


class ViewSalesReport implements FromView
{

    public $data;

    public function __construct($data)
    {

        $this->data = ($data);
    }

    public function view(): View
    {

        return view(
            'admin.pages.report.table',
            $this->data
        );
    }
}
