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
                    <td>{{$client->tel}}</td>
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