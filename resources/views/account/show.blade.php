@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="text-center">Account Info</h4>
                <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Modified</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">{{ $account->name }}</th>
                            <th scope="row">{{ $account->balance }}</th>
                            <th scope="row">{{ $account->updated_at->diffForHumans() }}</th>
                            <th scope="row">
                                <a href="{{  route('account.edit', $account) }}"><button class="btn btn-primary">Edit</button></a>
                                <form action="{{ route('account.destroy', $account) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </th>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
