@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h4 class="text-center text-uppercase text-muted">Cuentas</h4>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#modalAddAccount">
                AGREGAR
            </button>
        </div>
        @foreach ($accounts as $account)
        <div class="col-6 mt-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-uppercase text-muted m-0">ID: {{$account->id}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">Núm. cuenta</label>
                            <input customerId="{{$account->account_number}}" id="name" type="text" value="{{$account->account_number}}" class="form-control" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">dirección</label>
                            <input customerId="{{$account->balance}}" id="address" type="text" value="{{$account->balance}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form class="form-inline float-right" action="{{route('accounts.destroy', ['account' => $account->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-0">ELIMINAR</button>
                    </form>
                    <a class="ml-2 btn btn-warning rounded-0" data-toggle="modal" data-target="#modalEditAccount-{{$account->id}}">EDITAR</a>
                    

                    <!-- Modal Edit Account -->
                    <div class="modal fade" id="modalEditAccount-{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar cuenta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="{{route('accounts.update',['account'=>$account->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6 mt-2">
                                            <label for="">Núm. cuenta</label>
                                            <input type="text" value="{{$account->account_number}}" class="form-control" name="account_number" required>
                                        </div>
                                        <div class="col-12 col-md-6 mt-2">
                                            <label for="">Saldo</label>
                                            <input type="text" value="{{$account->balance}}" class="form-control" name="balance" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Seleccionar</th>
                                                            <th>Cliente</th>
                                                            <th>Dirección</th>
                                                            <th>Teléfono</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($customers as $customer)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" {{$account->customers()->find($customer->id) ? 'checked' : ''}} name="customers[]" value="{{$customer->id}}">
                                                            </td>
                                                            <td>{{$customer->name}}</td>
                                                            <td>{{$customer->address}}</td>
                                                            <td>{{$customer->phone}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success rouned-0">GUARDAR</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Add Account -->
<div class="modal fade" id="modalAddAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('accounts.store')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 mt-2">
                        <label for="">Núm. de cuenta</label>
                        <input type="number" minlength="16" maxlength="16" class="form-control" name="account_number" required>
                    </div>
                    <div class="col-12 col-md-6 mt-2">
                        <label for="">Saldo</label>
                        <input type="number" min="1000" max="100000" class="form-control" name="balance" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Cliente</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="customers[]" value="{{$customer->id}}">
                                        </td>
                                        <td>{{$customer->name}}</td>
                                        <td>{{$customer->address}}</td>
                                        <td>{{$customer->phone}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success rounded-0">GUARDAR</button>
            </div>
        </form>
      </div>
    </div>
</div>

@endsection