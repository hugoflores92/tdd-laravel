@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create Transaction
                    </div>
                    <div class="panel-body">
                        <form action="/transactions" method="POST">
                            @include('transactions.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection