<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Payment;
use App\Client;
use App\ClientPayment;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showPayments(){


            $payments = Payment::all();
            return view('payments',compact('payments'));

    }
    public function createPayment(){
        $status =  Payment::listStatus();
        $clients = Client::all();
        ///check Access
        if(Auth::user()->hasRole("admin") ||  Auth::user()->hasRole("accountant"))
        {
            return view('createPayment',compact('clients','status'));
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function doCreatePayment(Request $request){

        ///check Access
        if(Auth::user()->hasRole("admin") ||  Auth::user()->hasRole("accountant"))
        {
            $Client_id = $request->post('client');
            $Amount = $request->post('amount');
            $Source = $request->post('source');
            $Status = $request->post('status');

            $newPayment = new Payment();
            $newPayment->client_id = $Client_id;
            $newPayment->user_id = Auth::user()->getAuthIdentifier();
            $newPayment->amount = $Amount;
            $newPayment->source = $Source;
            $newPayment->status = $Status;
            $newPayment->save();
            if($Status == 4){

                $client = Client::find($Client_id);
                $newAmount = $Amount + $client->balance;

                $client->balance()->attach(
                    ['payment_id' => $newPayment->id],
                    ['new_amount' =>  $newAmount,'old_balance' => $client->balance]
                );
                $client->balance +=  $Amount;
                $client->save();
            }
            session()->flash('status', 'New Payment Created Successfully');
            return redirect()->route('payments',app()->getLocale());
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('payments',app()->getLocale());
        }



    }
    public function deletePayment($local , $id){

        ///check Access
        if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("accountant"))
        {

            $payment = Payment::find($id);

            if($payment->status == 4){
                $Client = Client::find($payment->client_id);
                $Client->balance -= $payment->amount;
                $Client->save();
                $Client->balance()->newPivotStatement()->where('payment_id',$id)->delete();
            }
            $payment ->delete();
            session()->flash('status', 'Payment Deleted , Client Balance Updated and Transaction deleted Successfully');
            return redirect()->route('payments',app()->getLocale());
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('payments',app()->getLocale());
        }



    }

    function paymentSearch(Request $request)
    {
        if($request->ajax())
        {

            $query = $request->get('query');
            if($query != '')
            {
                $payments = Payment::where('user_id', '=', $query)->get();

            }
            else
            {
                $payments = Payment::all();
            }

            $view = view("layouts.paymentSearch",compact('payments'))->render();
            return response()->json(['html'=>$view]);
        }
    }


}
