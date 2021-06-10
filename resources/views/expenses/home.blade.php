@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(!$expenses->first())
            <h4>No Records!</h4>
        @else
            <h4>Last Records Overview</h4>
            <table class="table">
                @foreach($expenses as $expense)
                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Category</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">{{ \Carbon\Carbon::parse($expense->date)->diffForHumans() }}</th>
                        <th scope="row">{{ $expense->amount }}</th>
                        <th scope="row">{{ $expense->category->name }}</th>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        @endif
    </div>
</div>
@endsection
