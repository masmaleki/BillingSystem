@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" row col-12">
            <div class="float-right">
                <div class="form-group">
                    <div class="btn-group btn-group-sm" role="group">
                        @if(Auth::user()->hasRole("admin"))
                        <button type="button" onclick='location.href="{{ route('createUser', app()->getLocale()) }}"' class="btn btn-success"><i class="fas fa-user-check"></i>Create New User</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->display_name}}</td>
                                    <td>
                                        <div class="form-group">
                                            <div class="btn-group btn-group-sm" role="group">


                                                    <button type="button" onclick='location.href="{{ route('editUser', [app()->getLocale(), $user->id] ) }}"' class="btn btn-info"><i class="fas fa-edit"></i> Edit</button>
                                                    <button type="button" onclick="location.href='#'" class="btn btn-success"><i class="fas fa-eye"></i> View</button>
                                                    @if(Auth::user()->hasRole('admin'))
                                                    <button type="button" onclick='location.href="{{ route('deleteUser', [app()->getLocale(), $user->id] ) }}"' class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
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