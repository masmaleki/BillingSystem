@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" row col-12">
            <div class="float-right">
                <div class="form-group">
                    <div class="btn-group btn-group-sm" role="group">
                        @if(Auth::user()->hasRole("admin")  || Auth::user()->hasRole("operator"))
                        <button type="button" onclick='location.href="{{ route('createClient', app()->getLocale()) }}"' class="btn btn-success"><i class="fas fa-plus"></i> New Client</button>
                        @endif
                    </div>
                </div>
            </div>
            @if(Auth::user()->hasRole("admin")  || Auth::user()->hasRole("accountant"))
            <div class="input-group mb-3">
                <input id="query" name="query" type="text" class="form-control" placeholder="Search Client" aria-label="Search by Client ID#" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button id="btn-search-client" class="btn btn-outline-secondary" type="button"><i id="preloader" class="fas fa-search"></i> Search</button>
                </div>
            </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Clients list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            @if(! Auth::user()->hasRole('operator'))
                            <table id="ClientTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tel</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Operations</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($clients as $client)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{$client->name}}</td>
                                    @if( Auth::user()->hasRole('admin'))
                                        <td>{{$client->email}}</td>
                                        <td>{{$client->tell}}</td>
                                    @else
                                        <td>******</td>
                                        <td>******</td>
                                    @endif
                                    <td>{{$client->balance}}</td>
                                    <td>
                                        <div class="form-group">
                                            <div class="btn-group btn-group-sm" role="group">

                                                @if( Auth::user()->hasRole('admin'))
                                                    <button type="button" onclick="location.href='#'" class="btn btn-info"><i class="fas fa-edit"></i> Edit</button>
                                                    <button type="button" onclick="location.href='#'" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                @endif
                                                    <button type="button" onclick='location.href="{{ route('paymentHistory', [app()->getLocale(), $client->id] ) }}"' class="btn btn-warning"><i class="fas fa-eye"></i> Balance History</button>



                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    You have Not Access to View Clients
                                </div>


                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection