<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyerRequest;
use App\Models\Buyer;
use App\Models\Campaign;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function showBuyers(Campaign $campaign)
    {
        $buyers = $campaign->buyers()->orderBy('id', 'desc')->get();
        return response($buyers, 201);
    }


    public function addBuyer(BuyerRequest $request)
    {
        $data = $request->validated();

        Buyer::create([
            'campaign_id' => $data['campaign_id'],
            'client_id' => $data['client_id'],
            'buyer_name' => $data['buyer_name'],
            'requests' => $data['requests'],
        ]);

        return response(['success' => 'New Buyer Got Created!'], 201);  
    }

    public function editBuyer(BuyerRequest $request)
    {
        $data = $request->validated();
        $buyer = Buyer::find($data['id']);
        $buyer->update($data);
        return response(['success' => 'Buyer Got Updated!'], 200);
    }

    public function deleteBuyer($id)
    {
        $buyer = Buyer::find($id);
        $buyer->delete();
        return response("", 204);
    }

    public function buyerDetail($campaignId, $buyerId)
    {
        $buyerDetail = Buyer::where('campaign_id', $campaignId)->find($buyerId);

        if(!$buyerDetail)
        {
            abort(404, "Item not found");
        }

        return response($buyerDetail, 201);
    }
}