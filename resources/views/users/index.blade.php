<x-layout>

    @section('content')
    <div class="container">

        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="col md-12">
                    <p>Usuário <span class="close closem text-right" style="margin-top:-10px">&times;</span></p>
                </div>

                <form method="POST" id="myForm" onsubmit="onformSubmit()">
                    @csrf

                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="Nome">Nome completo</label>
                                <input type="text" id="name" name="name" class="form-control" aria-describedby="Nome" placeholder=" nome completo" autofocus required>
                                <!--<small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control" id="" aria-describedby="emailHelp" placeholder=" email" autofocus required>
                                <!--<small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>-->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">CPF</label>
                                <input type="text" id="cpf" name="cpf" class="form-control" aria-describedby="CPF" placeholder=" cpf" autofocus required>
                                <!--<small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>-->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Telefone</label>
                                <input type="text" id="phone" name="phone" class="form-control" aria-describedby="Telefone" placeholder=" Telefone" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">CEP</label>
                                <input type="text" id="cep" name="cep" class="form-control" onchange="consultarCep()" aria-describedby="CEP" placeholder=" CEP" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Número</label>
                                <input type="text" id="number" name="number" class="form-control" aria-describedby="Número" placeholder=" Número" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="">Endereço</label>
                                <input type="text" id="address" name="address" class="form-control" aria-describedby="Endereço" placeholder=" Endereço" autofocus required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="">Complemento</label>
                                <input type="textarea" id="complement" name="complement" class="form-control" aria-describedby="Complemento" placeholder=" Complemento" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Bairro</label>
                                <input type="text" id="district" name="district" class="form-control" aria-describedby="Bairro" placeholder=" Bairro" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Cidade</label>
                                <input type="text" id="city" name="city" class="form-control" aria-describedby="Cidade" placeholder="Sua Cidade" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Estado</label>
                                <input type="text" id="state" name="state" class="form-control" aria-describedby="Estado" placeholder=" Estado" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Data de Nascimento</label>
                                <input type="date" id="birthday" name="birthday" class="form-control" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="InputPassword">Senha</label>
                                <input type="password" id="password" name="password" class="form-control" id="InputPassword" placeholder="Senha">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-check mt-4">
                                <input type="checkbox" name="active" class="form-check-input" id="check1" >
                                <label class="form-check-label" for="check1">Ativo</label> 
                            </div>
                        </div>
                    </div>

                    <button id="registerBtn" type="submit" class="btn btn-primary">Registar</button>
                    <button id="updateBtn" type="submit" class="btn btn-primary">Atualizar</button>

                </form>

            </div>
        </div>

        <div class="mb-3">
            <button type="button" id="openModalBtn" class="btn btn-primary">Criar novo</button>
        </div>
        <div class="card">
            <div class="card-header">Lista de usuários</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>


    @endsection

    @push('scripts')
    {{ $dataTable->scripts() }}
    @endpush

    <script>
        $('#meuModal').on('shown.bs.modal', function() {
            $('#meuInput').trigger('focus')
        })
    </script>



</x-layout>