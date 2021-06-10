@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('store.account') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Name: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Balance: </label>
                        <input type="number" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance') }}">
                        @error('balance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
