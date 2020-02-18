@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h4 class="text-center text-uppercase text-muted">Clientes</h4>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#modalAddCustomer">
                AGREGAR
            </button>
        </div>
        @foreach ($customers as $customer)
        <div class="col-6 mt-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-uppercase text-muted m-0">ID: {{$customer->id}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">Nombre</label>
                            <input customerId="{{$customer->id}}" id="name" type="text" value="{{$customer->name}}" class="form-control" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">dirección</label>
                            <input customerId="{{$customer->id}}" id="address" type="text" value="{{$customer->address}}" class="form-control" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">Teléfono</label>
                            <input customerId="{{$customer->id}}" id="phone" type="text" value="{{$customer->phone}}" class="form-control" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">Correo</label>
                            <input customerId="{{$customer->id}}" id="email" type="text" value="{{$customer->user->email}}" class="form-control" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">Número de cuenta</label>
                            <input customerId="{{$customer->id}}" id="account_number" type="text" value="{{$customer->accounts()->first()->account_number}}" class="form-control" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mt-2">
                            <label for="" class="text-uppercase text-muted">Saldo</label>
                            <input customerId="{{$customer->id}}" id="balance" type="text" value="${{$customer->accounts()->first()->balance}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form class="form-inline float-right" action="{{route('customers.destroy', ['customer' => $customer->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-0">ELIMINAR</button>
                    </form>
                    <a class="ml-2 btn btn-warning rounded-0" data-toggle="modal" data-target="#modalEditCustomer-{{$customer->id}}">EDITAR</a>
                    

                    <!-- Modal Edit Customer -->
                    <div class="modal fade" id="modalEditCustomer-{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="{{route('customers.update',['customer'=>$customer->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="">Nombre</label>
                                            <input type="text" value="{{$customer->name}}" class="form-control" name="name" required>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="">Dirección</label>
                                            <input type="text" value="{{$customer->address}}" class="form-control" name="address" required>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="">Teléfono</label>
                                            <input type="number" value="{{$customer->phone}}" class="form-control" name="phone" required>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="">Número de cuenta</label>
                                            <input type="number" value="{{$customer->accounts()->first()->account_number}}" step="1" minlength="16" name="account_number" class="form-control" required>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="">Saldo</label>
                                            <input type="number" value="{{$customer->accounts()->first()->balance}}" step="0.1" min="100" value="0.0" name="balance" class="form-control" required>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="">Correo</label>
                                            <input type="email" value="{{$customer->user->email}}" class="form-control" name="email" required>
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

<!-- Modal Add Customer -->
<div class="modal fade" id="modalAddCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('customers.store')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Dirección</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Teléfono</label>
                        <input type="number" class="form-control" name="phone" required>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Número de cuenta</label>
                        <input type="number" step="1" minlength="16" name="account_number" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Saldo</label>
                        <input type="number" step="0.1" min="100" value="0.0" name="balance" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Correo</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-12 col-md-4 mt-2">
                        <label for="">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
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



@endsection
