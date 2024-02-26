<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Models\Campaign;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function showAttributes(Campaign $campaign)
    {
        $fields = $campaign->attributes()->orderBy('id', 'asc')->get();
        return response($fields, 201);
    }

    public function addAttribute(AttributeRequest $request)
    {
        $data = $request->validated();

        Attribute::create([
            'campaign_id' => $data['campaign_id'],
            'field_name' => $data['field_name'],
            'field_type' => $data['field_type'],
            'field_description' => $data['field_description'],
        ]);

        return response(['success' => 'New Field Got Created!'], 201);  
    }

    public function editAttribute(AttributeRequest $request)
    {
        $data = $request->validated();
        $buyer = Attribute::find($data['id']);
        $buyer->update($data);
        return response(['success' => 'Field Got Updated!'], 200);
    }

    public function deleteAttribute($id)
    {
        $buyer = Attribute::find($id);
        $buyer->delete();
        return response("", 204);
    }
}