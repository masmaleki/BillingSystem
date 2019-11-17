@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Payment</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('doCreatePayment', app()->getLocale()) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Client</label>
                                <div class="col-md-6">
                                    <select id="client" name="client" class="form-control">
                                        <option disabled selected>Choose</option>
                                        @foreach($clients as $client)

                                            <option value="{{$client->id}}">{{$client->name}}</option>

                                        @endforeach


                                    </select>

                                    @error('client')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                                <div class="col-md-6">
                                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" required autocomplete="new-password">

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="source" class="col-md-4 col-form-label text-md-right">Source</label>
                                <div class="col-md-6">
                                    <select id="source" name="source" class="form-control">
                                        <option disabled selected>Choose</option>


                                            <option value="Online">Online</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="Handpay">Handpay</option>


                                    </select>
                                    @error('source')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-6">
                                    <select id="status" name="status" class="form-control">
                                        <option disabled selected>Choose</option>

                                    @foreach($status  as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                    @endforeach

                                    </select>
                                    @error('source')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
