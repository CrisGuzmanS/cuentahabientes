@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h5 class="text-center text-uppercase text-muted">{{$customer->name}}</h5>
        </div>
    </div>
    <div class="row">
        @foreach ($customer->accounts as $account)
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-2">
                            <label for="" class="text-uppercase text-muted">NÚMERO DE CUENTA</label>
                            <input type="text" class="form-control" value="{{$account->account_number}}" readonly>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="" class="text-uppercase text-muted">SALDO</label>
                            <input type="text" class="form-control" value="${{$account->balance}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection