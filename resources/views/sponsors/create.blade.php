{{--   Modal Create  --}}
<div class="modal" id="modalCreate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add Sponsor</h5>
                <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="modalCreateForm" method="post" action="{{ route("sponsors.store") }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabCreate1" role="tabpanel">
                            <div class="row">
                                <div class="col-12 col-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nome</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('name')  is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nome">
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
                                            <input type="email" class="form-control @error('email')  is-invalid @enderror" id="email" name="email"  value="{{ old('email') }}" placeholder="E-mail">
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
                                                <option value="{{ "Ativo" }}">Ativo</option>
                                                <option value="{{ "Inativo" }}">Inativo</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                            @endif
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

