{{--   Modal Edit --}}
<div class="modal" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Edit Sponsor </h5>
                <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="form">
                <form id="modalEditForm" method="post" action="{{ route('sponsors.update',  $sponsor->id )  }}">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <ul class="nav nav-tabs" id="tabEdit" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabEdit1" role="tab" aria-controls="profile"> Profile </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabEdit2" role="tab" aria-controls="settings"> Loans </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabEdit1" role="tabpanel">
                                <div class="row">
                                    <input type="text" class="form-control" id="id" name="id" value="{{ $sponsor->id }}" hidden="hidden">

                                    <div class="col-12 col-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nome</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('name')  is-invalid @enderror" id="name" name="name" value="{{ $sponsor->name }}" placeholder="Nome">
                                                @if($errors->has('name'))
                                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">E-mail</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                                </div>
                                                <input type="email" class="form-control @error('email')  is-invalid @enderror" id="email" name="email"  value="{{ $sponsor->email }}" placeholder="E-mail">
                                                @if($errors->has('email'))
                                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-12 col-md-12 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                                                </div>
                                                <select class="form-control" name="status" required>
                                                    <option value="Ativo" <?php if ($sponsor->status == "Ativo") echo "selected"; ?>>Ativo</option>
                                                    <option value="Inativo" <?php if ($sponsor->status == "Inativo") echo "selected"; ?>>Inativo</option>
                                                </select>
                                                @if($errors->has('status'))
                                                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabEdit2" role="tabpanel">
                                <div class="row">
                                    <div class="col-6 col-6 col-md-6 col-lg-3 col-xl-3">
                                        <div class="mb-3">
                                            <label for="emprestado" class="form-label">Total emprestado</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="emprestado" name="emprestado" placeholder="Emprestado" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="tabela-com-scroll" class="table-responsive mt-4">
                                        <table id="tableEmprestimo" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Cliente</th>
                                            <th>Data</th>
                                            <th>Empréstimo</th>
                                            <th>Juros(%)</th>
                                            <th>Pago</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabEdit3" role="tabpanel">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="modalSave" type="submit" class="btn btn-success"> Gravar</button>
                        <button id="modalCancel" type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
