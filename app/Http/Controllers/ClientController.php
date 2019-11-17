<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Payment;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showClients(){
        $clients = Client::all();
        return view('clients',compact('clients'));

    }

    public function createClient(){

        ///check Access
        if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("operator"))
        {
            return view('createClient');
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function doCreateClient(Request $request){

        ///check Access
        if(Auth::user()->hasRole("admin")  ||  Auth::user()->hasRole("operator"))
        {
            $name = $request->post('name');
            $email = $request->post('email');
            $address = $request->post('address');
            $tell = $request->post('tell');

            $newClient = new Client();
            $newClient->name = $name;
            $newClient->email = $email;
            $newClient->address = $address;
            $newClient->tel= $tell;
            $newClient->balance= 0;
            $newClient->save();
            session()->flash('status', 'New Client Created Successfully');
            return redirect()->route('clients',app()->getLocale());
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('clients',app()->getLocale());
        }



    }

    public function paymentHistory($local , $clientID){

        $client = Client::where('id','=',$clientID)->first();
        $transactions = $client->balance()->get();

        return view('transactions',compact('transactions','client'));

    }

    function clientSearch(Request $request)
    {
        if($request->ajax())
        {

            $query = $request->get('query');
            if($query != '')
            {
                $clients = Client::
                where('id', '=', $query)->
                orWhere('name', 'like', '%' . $query .'%' )->
                orWhere('email', 'like', '%' . $query . '%')->get();

            }
            else
            {
                $clients = Client::all();
            }

            $view = view("layouts.clientSearch",compact('clients'))->render();
            return response()->json(['html'=>$view]);
        }
    }
}
