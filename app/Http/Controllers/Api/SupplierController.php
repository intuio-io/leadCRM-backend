<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Campaign;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function showSuppliers(Campaign $campaign)
    {
        $suppliers = $campaign->suppliers()->orderBy('id', 'desc')->get();
        return response($suppliers, 201);
    }

    public function addSupplier(SupplierRequest $request)
    {
        $data = $request->validated();

        Supplier::create([
            'campaign_id' => $data['campaign_id'],
            'client_id' => $data['client_id'],
            'supplier_name' => $data['supplier_name'],
            'requests' => $data['requests'],
        ]);

        return response(['success' => 'New Supplier Got Created!'], 201);   
    }

    public function editSupplier(SupplierRequest $request)
    {
        $data = $request->validated();
        $supplier = Supplier::find($data['id']);
        $supplier->update($data);
        return response(['success' => 'Supplier Got Updated!'], 200);
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return response("", 204);
    }

    public function supplierDetail($campaignId, $supplierId)
    {
        $supplierDetail = Supplier::where('campaign_id', $campaignId)->find($supplierId);

        if(!$supplierDetail)
        {
            abort(404, "Item not found");
        }

        return response($supplierDetail, 201);
    }
}