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
                            <button class="btn btn-primary rounded-0" data-toggle="modal" data-target="#a{{$account->id}}">
                                TRANSFERENCIA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="a{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase">Transferencia monetaria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="" class="text-muted text-uppercase">Número de cuenta</label>
                            <input name="account_number" accountId="{{$account->id}}" type="number" minlength="16" maxlength="16" class="form-control inputAccountNumber">
                            <small class="text-muted">Introduce un número de cuenta válido</small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="" class="text-muted text-uppercase">Monto</label>
                            <input name="amount" accountId="{{$account->id}}" type="number" step="0.01" max="{{$account->balance}}" class="form-control inputAmount">
                            <small class="text-muted">Introduce un monto menor o igual a ${{$account->balance}}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-0 buttonTransfer" accountId="{{$account->id}}">TRANSFERIR</button>
                </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>

    class Transferencia{

        static async accountExists( accountNumber ){
            var accountExists = false;

            jQuery.ajax({
                url: `/api/accounts/account_number/${accountNumber}`,
                success: function (result) {
                    accountExists = true;
                },
                async: false
            });

            return accountExists;
        }

        static validAmount(){

        }
    }

    $(document).on('keyup', '.inputAccountNumber', async function(){

        const accountNumber = $(this).val()

        console.log( await Transferencia.accountExists(accountNumber) )

        if( await Transferencia.accountExists(accountNumber) ){
            $(this)
                .addClass('is-valid')
                .removeClass('is-invalid');
        }else{
            $(this)
                .addClass('is-invalid')
                .removeClass('is-valid');
        }

    });

    $(document).on('click', '#buttonTransfer', async function(){
        accountIdselected = $(this).attr('accountId');

        console.log( accountIdselected )

        //const amount = $(`.inputAmount[accountId=${}]`).val();
        //if( await Transferencia.accountExists() && Transferencia.validAmount() ){

        //}
    });

</script>

@endsection