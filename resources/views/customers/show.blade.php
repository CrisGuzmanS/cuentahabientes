@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h5 class="text-center text-uppercase text-muted">{{$customer->name}}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-2"></div>
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for="" class="text-uppercase text-muted">NÚMERO DE CUENTA</label>
                            <input type="text" class="form-control" value="{{$customer->accounts()->first()->account_number}}" readonly>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="" class="text-uppercase text-muted">SALDO</label>
                            <input type="text" class="form-control" value="${{$customer->accounts()->first()->balance}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-2"></div>
    </div>
</div>

@endsection