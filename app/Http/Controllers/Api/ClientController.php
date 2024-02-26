<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function showClients()
    {
        $clients = User::find(Auth()->user()->id)->clients()->orderBy('id', 'desc')->get();
        return response($clients, 201);
    }

    public function addClient(ClientRequest $request)
    {
        $data = $request->validated();

        Client::create([
            'user_id' => Auth()->user()->id,
            'company_name' => $data['company_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);

        return response(["success" => "New Client Got Created!"], 201);
    }

    public function editClient(ClientRequest $request)
    {
        $data = $request->validated();
        $client = Client::find($request -> id);
        $client->update($data);
        return response(['success' => 'Client Got Updated!'], 200);
    }

    public function delClient($id)
    {
        $client = Client::find($id);
        $client->delete();
        return response("", 204);
    }
}