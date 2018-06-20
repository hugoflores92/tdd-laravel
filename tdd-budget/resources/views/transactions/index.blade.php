@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-2 col-md-offset-10">
                        <form method="GET" id="month-form">
                            <select name="month" id="month" class="form-control" onchange="document.getElementById('month-form').submit()">
                                <option value="Jan" {{ $currentMonth == 'Jan' ? 'selected="selected"' : '' }}>January</option>
                                <option value="Feb" {{ $currentMonth == 'Feb' ? 'selected="selected"' : '' }}>February</option>
                                <option value="Mar" {{ $currentMonth == 'Mar' ? 'selected="selected"' : '' }}>March</option>
                                <option value="Apr" {{ $currentMonth == 'Apr' ? 'selected="selected"' : '' }}>April</option>
                                <option value="May" {{ $currentMonth == 'May' ? 'selected="selected"' : '' }}>May</option>
                                <option value="Jun" {{ $currentMonth == 'Jun' ? 'selected="selected"' : '' }}>June</option>
                                <option value="Jul" {{ $currentMonth == 'Jul' ? 'selected="selected"' : '' }}>July</option>
                                <option value="Aug" {{ $currentMonth == 'Aug' ? 'selected="selected"' : '' }}>August</option>
                                <option value="Sep" {{ $currentMonth == 'Sep' ? 'selected="selected"' : '' }}>September</option>
                                <option value="Oct" {{ $currentMonth == 'Oct' ? 'selected="selected"' : '' }}>October</option>
                                <option value="Nov" {{ $currentMonth == 'Nov' ? 'selected="selected"' : '' }}>November</option>
                                <option value="Dec" {{ $currentMonth == 'Dec' ? 'selected="selected"' : '' }}>December</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="/transactions/{{ $transaction->id }}">
                                        {{ $transaction->description }}
                                    </a>
                                </td>
                                <td>{{ $transaction->category->name }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>
                                    <form action="/transactions/{{ $transaction->id }}" method="POST">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger btn-xs" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection