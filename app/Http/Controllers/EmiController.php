<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmiService;

class EmiController extends Controller
{
    protected $emiService;

    public function __construct(EmiService $emiService)
    {
        $this->emiService = $emiService;
    }

    public function index()
    {
        // Just display the page. If data exists, show it.
        $data = $this->emiService->getEmiData();
        return view('emi_details', ['columns' => $data['columns'], 'rows' => $data['rows']]);
    }

    public function process()
    {
        $this->emiService->process();
        return redirect()->route('emi.index');
    }
}
