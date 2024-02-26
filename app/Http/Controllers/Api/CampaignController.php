<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use App\Models\Attribute;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CampaignController extends Controller
{
    public function showCampaigns()
    {
        $user = Auth::user();
        $campaigns = Campaign::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return response($campaigns, 201);
    }

    public function addCampaign(CampaignRequest $request)
    {
        $data = $request->validated();

       $campaign = Campaign::create([
            'user_id' => Auth()->user()->id,
            'campaign_name' => $data['campaign_name']
        ]);

        $this->generateDefaultAttributes($campaign->id);

        return response(['success' => 'New Campaign Got Created!'], 201);
    }

    public function editCampaign(CampaignRequest $request)
    {
        $data = $request->validated();
        $campaign = Campaign::find($data['id']);
        $campaign->update($data);
        return response(['success' => 'Campaign Got Updated!'], 200);
    }

    public function delCampaign($id)
    {
        $campaign = Campaign::find($id);
        $campaign->delete();
        return response("", 204);
    }

    public function campaignDetail($id)
    {
        $user = Auth::user();
        $campaignDetail = Campaign::where('user_id', $user->id)->find($id);

        if(!$campaignDetail)
        {
            abort(404, "Item not found");
        }

        return response($campaignDetail, 201);
    }


    public function resetAttributes($id)
    {
      Attribute::where('campaign_id', $id)->delete(); 
      $this->generateDefaultAttributes($id);

      return response(['success' => 'Fields Got Resetted!']);
    }


    public function generateDefaultAttributes($id)
    {
      $campaignAttributes = [
        [
         'campaign_id' => $id,
         'field_name' => 'first_name',
         'field_type' => 'String',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(),
        ],
        [
         'campaign_id' => $id,
         'field_name' => 'last_name',
         'field_type' => 'String',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(),
        ],
        [
         'campaign_id' => $id,
         'field_name' => 'email',
         'field_type' => 'Email',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(), 
        ],
        [
         'campaign_id' => $id,
         'field_name' => 'phone',
         'field_type' => 'Int',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(),
        ],
        [
         'campaign_id' => $id,
         'field_name' => 'location',
         'field_type' => 'String',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(),
        ]     
       ];
 
      return Attribute::insert($campaignAttributes);
    }


}