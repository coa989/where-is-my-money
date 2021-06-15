@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="container alert alert-success">
            {{ session('status') }}
        </div>
    @endif
<div class="container">
    <div class="row justify-content-center">
        @if(!$expenses->first())
            <h4>No Records!</h4>
        @else
            <h4>Last Records Overview</h4>
            <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Category</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $expense)
                        <tr>
                        <th scope="row">{{ \Carbon\Carbon::parse($expense->date)->diffForHumans() }}</th>
                        <th scope="row">{{ $expense->amount }}</th>
                        <th scope="row">{{ $expense->category->name }}</th>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
