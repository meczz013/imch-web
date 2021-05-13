<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\CovidCIFRequest;
use App\Models\Entry;

class CovidCIFController extends Controller
{

	public function index()
	{
		$genders = ['Male', 'Female'];
		$civil_statuses = ['Single', 'Married', 'Widowed', 'Separated', 'Divorced', 'In a civil union', 'In a domestic partnership'];
		return view('frontend.pages.covid-cif.index', compact('genders', 'civil_statuses'));
	}

    public function store(CovidCIFRequest $request)
    {
    	$data = new Entry;
        $data->fill($request->except(['birthday', 'is_history_of_travel_symptom', 'is_returning_ofw', 'is_locally_stranded_lsi']));
        $data->status = 'Pending';
        $data->birthday = \Carbon\Carbon::createFromFormat('m/d/Y', $request->birthday)->format('Y-m-d');
        $data->is_history_of_travel_symptom = isset($request->is_history_of_travel_symptom) ? 1 : 0;
        $data->is_returning_ofw = isset($request->is_returning_ofw) ? 1 : 0;
        $data->is_locally_stranded_lsi = isset($request->is_locally_stranded_lsi) ? 1 : 0;
        $data->save();

        return redirect()->back()->with('flash_success', 'Form submitted successfully.');
    }
}
