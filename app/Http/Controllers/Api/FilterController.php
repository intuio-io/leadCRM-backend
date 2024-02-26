<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\Campaign;
use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function showFilters(Campaign $campaign)
    {
        $filters = $campaign->filters()->orderBy('id', 'desc')->get();
        return response($filters, 201);
    }


    public function addFilter(FilterRequest $request)
    {
        $data = $request->validated();

        Filter::create([
            'campaign_id' => $data['campaign_id'],
            'filter_type' => $data['filter_type'],
            'filter_condition' => $data['filter_condition'],
            'filter_value' => $data['filter_value'],
        ]);

        return response(['success' => 'New Filter Was Added!'], 201);
    }

    public function editFilter(FilterRequest $request)
    {
        $data = $request->validated();
        $filter = Filter::find($data['id']);
        $filter->update($data);
        return response(['success' => 'Filter Got Updated!'], 200);
    }

    public function deleteFilter($id)
    {
        $filter = Filter::find($id);
        $filter->delete();
        return response("", 204);
    }
}