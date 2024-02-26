<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Lead;
use App\Rules\ValidCampaignOwnerRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function addLead(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'campaign_id' => ['required','integer', new ValidCampaignOwnerRule]
          ]);
    

          // Validates the Campaign ID belongs to the current user
          
          if($validateData->fails())
          
          {
            return response()->json([
                'status' => 'ERROR',
                'message' => $validateData->errors()->first(),
            ], 401);
          }
          
          
          $campaign = Campaign::find($request->campaign_id);
          
          // Converts the campaign Requirements from collections to array
          
          $rules = $campaign->attributes->pluck('field_type', "field_name")->toArray();
          
          $processedData = [];
          
          // Adds the required to all the attributes

          foreach($rules as $key => $value)
          {
              $processedData[$key] = $value."|required";   
          }

          $validator = Validator::make($request->all(), $processedData);
          
          if($validator->fails())
          {
              return response()->json([
                  'status' => "ERROR",
                  'message' => $validator->errors()->first()], 401);  
          }

          // now checking for filters

          $filter = $campaign->filters->pluck('filter_value', 'filter_type')->toArray();

          $difference = array_diff($filter, $request->all());

          

          // inserting of the data in the database even if the filter data is not matched with a rejected status



        $data = $request->all();

        // Extracting the campaign_id from $data
        $campaign_id = $data['campaign_id'];

        // Remove campaign_id from the array, and what remains will be lead details
        unset($data['campaign_id']);

        // Store lead details as JSON
        $lead_details = json_encode($data);

         if(count($difference) === 0)
         {
            $attributes = [
                'campaign_id' => $campaign_id,
                'lead_details' => $lead_details,
                'status' => 'Accepted'
            ];

            Lead::create($attributes);

            return response()->json([
                'status' => 'ACCEPTED',
                'message' => '',
            ]);
        }
            else
            {
                $message = "Filter Rejected: ".key($difference). " is invalid";

                $attributes = [
                    'campaign_id' => $campaign_id,
                    'lead_details' => $lead_details,
                    'status' => $message,
                ];
    
                Lead::create($attributes);

                return response()->json(['status' => 'ERROR',
                'message' => $message]);
            }
         }


         public function showLeads(Campaign $campaign)
         {
            $leads = $campaign->buyers()->orderBy('id', 'desc')->get();
            return response($leads, 201);
         }
    
    }