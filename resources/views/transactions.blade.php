@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" row col-12">
            <div class="float-right">
                <div class="form-group">
                    <div class="btn-group btn-group-sm" role="group">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Balance History -> Client : <span class="badge badge-primary"> {{$client->name}} </span></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <table id="PaymentsTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Source</th>
                                    <th scope="col">By User</th>
                                    <th scope="col">Old Balance</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{$transaction->created_at}}</td>
                                    <td>{{$transaction->source}}</td>
                                    <td>{{$transaction->user->name}}</td>
                                    <td>{{$transaction->pivot->old_balance}}</td>
                                    <td>+ {{$transaction->amount}}</td>
                                    <td>{{$transaction->pivot->new_amount}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection