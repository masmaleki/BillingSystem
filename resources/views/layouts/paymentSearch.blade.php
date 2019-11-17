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
        <th scope="col">Operations</th>
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