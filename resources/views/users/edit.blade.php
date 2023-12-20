{{--   Modal Edit --}}
{{--   data-backdrop="static" evita fechar o formulario se clicar fora  --}}
    <div class="modal" id="modalEdit" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alterar Usuario</h5>
                    <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="modalEditForm" method="post" action="{{ route('users.update', $user->id )  }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')

                        <ul class="nav nav-tabs" id="tabEdit" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabEdit1" role="tab" aria-controls="profile"><i class="fas fa-address-card"></i> Profile</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tabCreate1" role="tabpanel">
                                <div class="row">

                                    <div class="bg-white">
                                        <div class="row">
                                            <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                            <div class="col-md-4 border-right d-flex flex-column justify-content-center align-items-center">
                                                <div class="d-flex flex-column align-items-center text-center py-4">
                                                    <img id="imagemPreview" class="rounded-circle mt-0"
                                                         @if($user->photo)
                                                             src="/images/users/{{ $user->photo }}"
                                                         @else
                                                             src="/images/users/photo.png"
                                                         @endif
                                                         alt="Foto do usuário"
                                                         width="150" height="150"
                                                    >
                                                </div>

                                                <label for="photo" class="custom-file-upload">
                                                    <input type="file" id="photo" name="photo" style="display: none;" onchange='exibirImagem()' accept='image/*'>
                                                    <span style="display: block; text-align: center">Selecione um arquivo</span>
                                                </label>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="p-0 py-1">
                                                    <div class="row m-10">

                                                        <div class="col-12 col-12 col-md-12 col-lg-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nome</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend desktop">
                                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control @error('name')  is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" placeholder="Nome" required>
                                                                    @if($errors->has('name'))
                                                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-12 col-md-12 col-lg-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">E-mail</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend  desktop">
                                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                                    </div>
                                                                    <input type="email" class="form-control @error('email')  is-invalid @enderror" id="email" name="email"  value="{{  $user->email }}" placeholder="E-mail" required>
                                                                    @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Senha</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend  desktop">
                                                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                                    </div>
                                                                    <input type="password" class="form-control @error('password')  is-invalid @enderror" id="password" name="password"  value="" placeholder="Senha">
                                                                    @if($errors->has('password'))
                                                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="password2" class="form-label">Confirmar Senha</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend  desktop">
                                                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                                    </div>
                                                                    <input type="password" class="form-control @error('password2')  is-invalid @enderror" id="password2" name="password2" value=""
                                                                           onblur="pesquisaCep(this.value,'modalCreateForm');"
                                                                           placeholder="Confirmar Senha">
                                                                    @if($errors->has('password2'))
                                                                        <div class="invalid-feedback">{{ $errors->first('password2') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                                                                    </div>
                                                                    <select class="form-control" name="status" required>
                                                                        <option value="Ativo" <?php if ($user->status == "Ativo") echo "selected"; ?>>Ativo</option>
                                                                        <option value="Inativo" <?php if ($user->status == "Inativo") echo "selected"; ?>>Inativo</option>
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

                                    </div>
                                </div>
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
