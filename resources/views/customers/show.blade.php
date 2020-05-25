@extends('layouts.app')

@section('content')

<input type="hidden" class="form-control" readonly id="inputCustomerId" value="{{Auth::user()->customer->id}}">

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
                            <input type="text" class="form-control inputOriginAccountNumber" accountId="{{$account->id}}" value="{{$account->account_number}}" readonly>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="" class="text-uppercase text-muted">💰 SALDO</label>
                            <input type="text" class="form-control inputOriginAmount" accountId="{{$account->id}}" value="${{$account->balance}}" readonly>
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
                    <input name="origin_account_number" accountId="{{$account->id}}" type="hidden" minlength="16" maxlength="16" class="form-control inputOriginAccountNumber" value="{{$account->account_number}}" readonly>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // =========
    // FUNCTIONS
    // =========

    function sleep(ms) {
        var start = new Date().getTime(), expire = start + ms;
        while (new Date().getTime() < expire) { }
        return;
    }

    // =======
    // CLASSES
    // =======

    class Transfer{
        constructor( originAccountNumber, destinationAccountNumber, amount, customerId ){
            this.originAccountNumber = originAccountNumber;
            this.destinationAccountNumber = destinationAccountNumber;
            this.amount = amount;
            this.customerId = customerId;
        }
    }

    class AccountService{
        static updateAmounts(){
            $('.inputOriginAccountNumber').each( function(){
                const accountId = $(this).attr('accountId');
                
                $.ajax({
                    url: `/api/accounts/${accountId}`,
                    async: false,
                    success: function(response){
                        $(`.inputOriginAmount[accountId=${accountId}]`).val(response.account.balance)
                    },
                    error: function(error){
                        console.log(error)
                    }
                });

            } );
        }
    }

    class TransferService{

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

        static validAmount(amount, maxAmount){

            if( isNaN(parseFloat(amount)) ){
                return false;
            }

            return parseFloat(amount) <= parseFloat(maxAmount); 
        }

        static async storeOrFail( transfer ){

            const transferRequest = JSON.parse( localStorage.getItem('transferRequest') );

            const response = await $.ajax({
                url: `/api/transactions`,
                method: "POST",
                //contentType: 'application/json',
                tryCount: 0,
                retryLimit: 5,
                data: { 
                    originAccountNumber: transfer.originAccountNumber,
                    destinationAccountNumber: transfer.destinationAccountNumber,
                    amount: transfer.amount,
                    customerId: transfer.customerId,
                    },
                success: function (result) {
                    AccountService.updateAmounts();
                    swal("Tu transacción ha sido realizada con éxito 😊", "¡Sigue con nosotros!", "success");
                    return true;
                },
                error: function(error){
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit-1) {
                        console.log({
                            tryCount: this.tryCount,
                            error
                        })
                        sleep(1000);
                        $.ajax(this);
                        return;
                    }
                    swal("Tuvimos problemas con el servidor.", "Inténtalo más tarde o comunicate con soporte técnico. 😥", "error");
                    return false;
                },
                async: false
            });
        }

        static storeRequest( transfer ){
            localStorage.setItem( 'transferRequest', JSON.stringify({
                transfer: transfer,
                attemps: 0
            }) );
        }
    }

    $(document).on('keyup', '.inputAccountNumber', async function(){

        const accountNumber = $(this).val()

        if( await TransferService.accountExists(accountNumber) ){
            $(this)
                .addClass('is-valid')
                .removeClass('is-invalid');
        }else{
            $(this)
                .addClass('is-invalid')
                .removeClass('is-valid');
        }

    });

    $(document).on('click', '.buttonTransfer', async function(){

        const accountIdselected = $(this).attr('accountId');
        const amount = $(`.inputAmount[accountId=${accountIdselected}]`).val()
        const maxAmount = $(`.inputAmount[accountId=${accountIdselected}]`).attr('max')
        const destinationAccountNumber = $(`.inputAccountNumber[accountId=${accountIdselected}]`).val();
        const originAccountNumber = $(`.inputOriginAccountNumber[accountId=${accountIdselected}]`).val();
        const customerId = $('#inputCustomerId').val();

        //if( await TransferService.accountExists(destinationAccountNumber) && TransferService.validAmount(amount, maxAmount) ){
            const transfer = new Transfer( originAccountNumber, destinationAccountNumber, amount, customerId )
            TransferService.storeRequest( transfer );
            $('.modal').modal('hide');
            TransferService.storeOrFail( transfer );
        //}
    });

</script>

@endsection