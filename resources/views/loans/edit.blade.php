{{--   Modal Create  --}}
<div class="modal" id="modalEdit" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Loan</h5>
                <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="form">
                <form id="modalEditForm" method="post" action="{{ route('loans.update', $loan->id )  }}">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <ul class="nav nav-tabs" id="tabCreate" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabCreate1" role="tab" aria-controls="profile">Loan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabCreate2" role="tab" aria-controls="profile">Payments</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tabCreate1" role="tabpanel">
                            <div class="col-12 col-12 col-lg-12 col-xl-12">
                                <div class="row">

                                    <input type="text" class="form-control" id="id" name="id" value="{{ $loan->id }}" hidden="hidden">

                                    <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="mb-3">
                                            <?php  $sponsors = \App\Models\Sponsor::all() ?>
                                            <label for="sponsors" class="form-label">Sponsor</label>

                                            <select id="sponsors" name="sponsor_id" class="form-control select2-single">
                                                <option value="">Select a sponsor</option>
                                                @foreach($sponsors as $sponsor)
                                                    <option @if($loan->sponsor_id == $sponsor->id) selected @endif value="{{$sponsor->id}}">{{ $sponsor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="clients" class="form-label">Cliente</label>
                                            <?php  $clients = \App\Models\Client::where('status','=', 'Ativo')->get() ?>
                                            <select id="clients" name="client_id" class="form-control select2-single">
                                                <option value="">Select a client</option>
                                                @foreach($clients as $client)
                                                    <option @if($loan->client_id == $client->id) selected @endif value="{{$client->id}}">{{ $client->first_name }} {{ $client->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="loan_date" class="form-label">Data</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  desktop">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="date" class="form-control @error('loan_date')  is-invalid @enderror" id="loan_date" name="loan_date" value="{{ $loan->loan_date }}" placeholder="Data">
                                                @if($errors->has('loan_date'))
                                                    <div class="invalid-feedback">{{ $errors->first('loan_date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="amount_original" class="form-label">Empréstimo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  desktop">
                                                    <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('amount_original')  is-invalid @enderror" id="amount_original" name="amount_original" value="{{ $loan->amount_original }}" placeholder="Origin">
                                                @if($errors->has('amount_original'))
                                                    <div class="invalid-feedback">{{ $errors->first('amount_original') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Valor Atual</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  desktop">
                                                    <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('amount')  is-invalid @enderror" id="amount" name="amount" value="{{ $loan->amount }}" placeholder="Empréstimo">
                                                @if($errors->has('amount'))
                                                    <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="fees" class="form-label">Valor do Juros</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  desktop">
                                                    <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('fees')  is-invalid @enderror" id="fees" name="fees" value="{{ $loan->fees }}" placeholder="Juros">
                                                @if($errors->has('fees'))
                                                    <div class="invalid-feedback">{{ $errors->first('fees') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="total_paid" class="form-label">Total Pago</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  desktop">
                                                    <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('total_paid')  is-invalid @enderror" id="total_paid" name="total_paid" value="{{ $loan->total_paid }}" placeholder="Total Pago">
                                                @if($errors->has('total_paid'))
                                                    <div class="invalid-feedback">{{ $errors->first('total_paid') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend desktop">
                                                    <span class="input-group-text">
                                                        <i class='fas fa-exclamation-triangle'></i>
                                                    </span>
                                                </div>
                                                <select class="form-control" name="status" required>
                                                    <option value="Aberto" <?php if ($loan->status == "Aberto") echo "selected"; ?>>Aberto</option>
                                                    <option value="Fechado" <?php if ($loan->status == "Fechado") echo "selected"; ?>>Fechado</option>
                                                </select>
                                                @if($errors->has('status'))
                                                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabCreate2" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 col-12 col-lg-12 col-xl-12">
                                        <div id="tabela-com-scroll" class="table-responsive mt-4 minhaTable" style="max-height: 400px">
                                            <table id="tablePayments" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="data">Data(Pag)</th>
                                                    <th class="numero">Devedor</th>
                                                    <th class="numero">($)Juros</th>
                                                    <th class="numero">($)Valor</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button id="modalSave"   type="submit" class="btn btn-success"> Gravar</button>
                    <button id="modalCancel" type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

