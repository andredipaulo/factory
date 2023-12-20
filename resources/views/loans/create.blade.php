{{--   Modal Create  --}}
    <div class="modal" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Loans</h5>
                    <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="modalCreateForm" method="post" action="{{ route("loans.store") }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf


                    <ul class="nav nav-tabs" id="tabCreate" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabCreate1" role="tab" aria-controls="profile">Payment</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tabCreate1" role="tabpanel">
                            <div class="row">

                                <div class="col-12 col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="mb-3">
                                        <label for="loan" class="form-label">Empréstimo</label>
                                        <?php  $loans = \App\Models\Loan::where('status','Aberto')->get() ?>
                                        <select id="loan" name="loan_id" class="form-control select2-single">
                                            <option value="">Select a loan</option>
                                            @foreach($loans as $loan)
                                                <option value="{{$loan->id}}">[ {{ $loan->id }} - {{ $loan->sponsor->name }} - {{ $loan->amount }}] {{ $loan->client->first_name }} {{ $loan->client->last_name }}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="sponsor" class="form-label">Sponsor</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="sponsor" name="sponsor" value="{{ old('sponsor') }}" placeholder="Sponsor" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Client</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Nome" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="amount_original" class="form-label">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Amount" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-2 col-xl-2">
                                    <div class="mb-3">
                                        <label for="fees" class="form-label">Fees</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="fees" name="fees" value="{{ old('fees') }}" placeholder="Fees" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="payment_date" class="form-label">Payment Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ old('payment_date') }}" placeholder="Payment Date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-2 col-xl-2">
                                    <div class="mb-3">
                                        <label for="amount_fees" class="form-label">Amount Fees</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="amount_fees" name="amount_fees" value="{{ old('amount_fees') }}" placeholder="Amount Fees">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-12 col-md-12 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="amount_paid" class="form-label">Amount Paid</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="amount_paid" name="amount_paid" value="{{ old('amount_paid') }}" placeholder="Amount Paid">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button id="modalSave"   type="submit" class="btn btn-success"> Cadastrar</button>
                    <button id="modalCancel" type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

