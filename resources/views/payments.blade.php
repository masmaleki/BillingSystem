@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" row col-12">
            <div class="float-right">
                <div class="form-group">
                    <div class="btn-group btn-group-sm" role="group">
                        @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("accountant"))
                        <button type="button" onclick='location.href="{{ route('createPayment', app()->getLocale()) }}"' class="btn btn-success"><i class="fas fa-plus"></i> New Payment</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input id="query" name="query" type="text" class="form-control" placeholder="Search by User ID#" aria-label="Search by Client ID#" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button id="btn-search" class="btn btn-outline-secondary" type="button"><i id="preloader" class="fas fa-search"></i> Search</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payments list</div>

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
                                    <th scope="col">Amount</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">By User</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Source</th>
                                    <th scope="col">Status</th>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole("accountant"))
                                        <th scope="col">Operations</th>
                                    @endif

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{$payment->amount}}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('operator'))
                                            {{$payment->client->id}}
                                        @else
                                            {{$payment->client->name}}
                                        @endif
                                       </td>
                                    <td>{{$payment->user->name}}</td>
                                    <td>{{$payment->created_at}}</td>
                                    <td>{{$payment->source}}</td>
                                    <td>{{$payment->statusLabel()}}</td>
                                    <td>
                                        <div class="form-group">
                                            <div class="btn-group btn-group-sm" role="group">

                                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole("accountant"))
                                                    <button type="button" onclick="location.href='#'" class="btn btn-info"><i class="fas fa-edit"></i> Edit</button>
                                                    <button type="button" onclick='location.href="{{ route('deletePayment', [app()->getLocale(), $payment->id] ) }}"' class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                    @endif
                                            </div>
                                        </div>

                                    </td>
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