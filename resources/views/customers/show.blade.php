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
                            <label for="" class="text-uppercase text-muted">💳 NÚMERO DE CUENTA</label>
                            <input type="text" class="form-control" value="{{$account->account_number}}" readonly>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="" class="text-uppercase text-muted">💰 SALDO</label>
                            <input type="text" class="form-control" value="${{$account->balance}}" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary rounded-0" data-toggle="modal" data-target="#exampleModal">
                                TRANSFERENCIA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-uppercase" id="exampleModalLabel">Transferencia monetaria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row mt-2">
                <div class="col-12">
                    <label for="" class="text-muted text-uppercase">Número de cuenta</label>
                    <input name="account_number" id="inputAccountNumber" type="number" minlength="16" maxlength="16" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <label for="" class="text-muted text-uppercase">Monto</label>
                    <input name="amount" id="inputAmount" type="number" minlength="16" maxlength="16" class="form-control">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="buttonTransfer" class="btn btn-primary rounded-0">TRANSFERIR</button>
        </div>
        </div>
    </div>
</div>

<script>

    class Transferencia{

        static getAccountNumber(){
            return $('#inputAccountNumber').val()
        }

        static accountExists(){
            const accountNumber = this.getAccountNumber();

            jQuery.ajax({
                url: `/api/accounts/account_number/${accountNumber}`,
                success: function (result) {
                    console.log(result)
                },
                error: function (error){
                    console.error(error)
                },
                async: false
            });

        }
    }

    $(document).on('keyup', '#inputAccountNumber', function(){

        if(Transferencia.accountExists()){
            // Hacer el input color verde representando que existe la cuenta
        }else{
            // Hacer el input color rojo representando que no existe la cuenta
        }

    });

</script>

@endsection