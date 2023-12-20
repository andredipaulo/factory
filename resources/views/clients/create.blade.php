{{--   Modal Create  --}}
{{--   data-backdrop="static" evita fechar o formulario se clicar fora  --}}
    <div class="modal" id="modalCreate" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Cliente</h5>
                    <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="modalCreateForm" method="post" action="{{ route("clients.store") }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf


                    <ul class="nav nav-tabs" id="tabEdit" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabCreate1" role="tab" aria-controls="profile"><i class="fas fa-address-card"></i> Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabCreate2" role="tab" aria-controls="settings"><i class="fas fa-file-invoice-dollar"></i> Empréstimos</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabCreate3" role="tab" aria-controls="messages"><i class="fas fa-bullhorn"></i> Avisos</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tabCreate1" role="tabpanel">
                            <div class="row">

                                <div class="col-6 col-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">Nome</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend desktop">
                                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('first_name')  is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Nome" required>
                                            @if($errors->has('first_name'))
                                                <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Sobrenome</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('last_name')  is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Sobrenome" required>
                                            @if($errors->has('last_name'))
                                                <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 col-3 col-md-2 col-lg-2 col-xl-2">
                                    <div class="mb-3">
                                        <label for="limit" class="form-label">Limite</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend desktop">
                                                <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('limit')  is-invalid @enderror" id="limit" name="limit" value="{{ old('limit') }}" placeholder="Limite">
                                            @if($errors->has('limit'))
                                                <div class="invalid-feedback">{{ $errors->first('limit') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-9 col-9 col-md-7 col-lg-7 col-xl-7">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                            </div>
                                            <input type="email" class="form-control @error('email')  is-invalid @enderror" id="email" name="email"  value="{{ old('email') }}" placeholder="E-mail">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5 col-5 col-md-3 col-lg-3 col-xl-3">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Telefone</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('phone')  is-invalid @enderror" id="phone" name="phone"  value="{{ old('phone') }}" placeholder="Telefone">
                                            @if($errors->has('phone'))
                                                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 col-4 col-md-3 col-lg-3 col-xl-3">
                                    <div class="mb-3">
                                        <label for="postcode2" class="form-label">Cep</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="far fa-map"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('postcode')  is-invalid @enderror" id="postcode" name="postcode" value="{{ old('postcode') }}"
                                                   onblur="pesquisaCep(this.value,'modalCreateForm');" placeholder="Cep">
                                            @if($errors->has('postcode'))
                                                <div class="invalid-feedback">{{ $errors->first('postcode') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>



                                <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="address2" class="form-label">Endereço</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="far fa-map"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('address')  is-invalid @enderror" id="address" name="address"  value="{{ old('address') }}" placeholder="Endereço">
                                            @if($errors->has('address'))
                                                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-7 col-xl-7">
                                    <div class="mb-3">
                                        <label for="complement2" class="form-label">Complemento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="far fa-map"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('complement')  is-invalid @enderror" id="complement" name="complement"  value="{{ old('complement') }}" placeholder="Complemento">
                                            @if($errors->has('complement'))
                                                <div class="invalid-feedback">{{ $errors->first('complement') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-5 col-xl-5">
                                    <div class="mb-3">
                                        <label for="neighborhood2" class="form-label">Bairro</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="far fa-map"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('neighborhood')  is-invalid @enderror" id="neighborhood" name="neighborhood"  value="{{ old('neighborhood') }}" placeholder="Bairro">
                                            @if($errors->has('neighborhood'))
                                                <div class="invalid-feedback">{{ $errors->first('neighborhood') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-6 col-md-6 col-lg-7 col-xl-7">
                                    <div class="mb-3">
                                        <label for="city2" class="form-label">Cidade</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="far fa-map"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('city')  is-invalid @enderror" id="city" name="city"  value="{{ old('city') }}" placeholder="Cidade">
                                            @if($errors->has('city'))
                                                <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 col-3 col-md-3 col-lg-2 col-xl-2">
                                    <div class="mb-3">
                                        <label for="state2" class="form-label">Estado</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend  desktop">
                                                <span class="input-group-text"><i class="far fa-map"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('state')  is-invalid @enderror" id="state" name="state"  value="{{ old('state') }}" placeholder="Estado">
                                            @if($errors->has('state'))
                                                <div class="invalid-feedback">{{ $errors->first('state') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 col-3 col-md-3 col-lg-3 col-xl-3">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                                            </div>
                                            <select class="form-control" name="status" required>
                                                <option value="Ativo">Ativo</option>
                                                <option value="Inativo">Inativo</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="tabCreate2" role="tabpanel">
                            <div class="row">
                                <div class="col-12 col-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-6 col-6 col-md-3 col-lg-6 col-xl-6">
                                            <div class="mb-3">
                                                <label for="sponsors" class="form-label">Sponsor</label>
                                                    <?php  $sponsors = \App\Models\Sponsor::all() ?>
                                                <select id="sponsors" name="sponsors" class="form-control select2-single">
                                                    <option value="">Select a sponsor</option>
                                                    @foreach($sponsors as $sponsor)
                                                        <option value="{{$sponsor->id}}">{{ $sponsor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6 col-6 col-md-3 col-lg-3 col-xl-3">
                                            <div class="mb-3">
                                                <label for="limitEmprestimo" class="form-label">Limite</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend  desktop">
                                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('limit')  is-invalid @enderror" id="limitEmprestimo" name="limitEmprestimo" value="{{ old('limit') }}" placeholder="Limite" readonly>
                                                    @if($errors->has('limit'))
                                                        <div class="invalid-feedback">{{ $errors->first('limit') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-6 col-md-3 col-lg-3 col-xl-3">
                                            <div class="mb-3">
                                                <label for="devedor" class="form-label">Devedor</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend  desktop">
                                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('devedor')  is-invalid @enderror" id="devedor" name="devedor" value="{{ old('devedor') }}" placeholder="Devedor" readonly>
                                                    @if($errors->has('devedor'))
                                                        <div class="invalid-feedback">{{ $errors->first('devedor') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-6 col-md-3 col-lg-3 col-xl-3">
                                            <div class="mb-3">
                                                <label for="valor" class="form-label">Empréstimo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend  desktop">
                                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('valor')  is-invalid @enderror" id="valor" name="valor" value="{{ old('valor') }}" placeholder="Empréstimo">
                                                    @if($errors->has('valor'))
                                                        <div class="invalid-feedback">{{ $errors->first('valor') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-6 col-md-3 col-lg-3 col-xl-3">
                                            <div class="mb-3">
                                                <label for="juros" class="form-label">Valor do Juros</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend  desktop">
                                                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('juros')  is-invalid @enderror" id="juros" name="juros" value="{{ old('juros') }}" placeholder="Juros">
                                                    @if($errors->has('juros'))
                                                        <div class="invalid-feedback">{{ $errors->first('juros') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-6 col-md-4 col-lg-3 col-xl-3">
                                            <div class="mb-3">
                                                <label for="date" class="form-label">Data</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" class="form-control @error('date')  is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" placeholder="Data">
                                                    @if($errors->has('date'))
                                                        <div class="invalid-feedback">{{ $errors->first('date') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3 col-3 col-md-3 col-lg-3 col-xl-3">
                                            <label class="form-label"></label>
                                            <div class="row">
                                                <a  onclick="gerarEmprestimo()" class="btn btn-success"> Empréstimo</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="table-responsive mt-4">
                                            <table id="tableEmprestimo" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Sponsor</th>
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
                            </div>
                        </div>
                        <div class="tab-pane" id="tabCreate3" role="tabpanel">

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

