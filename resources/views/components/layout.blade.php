<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills pb-3 p-3 bg-dark text-white border-bottom" data-bs-theme="dark" id="pills-tab" role="tablist">
                <li class="nav-item p-2">
                    Sistema de Gerenciamento
                </li>
                <li class="nav-item last float-right" style="width: 80%">
                    <a class="btn btn-outline-secondary" style="float: right;color:#fff" id="pills-profile-tab" data-toggle="pill" href="/login" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="bi bi-box-arrow-left"></i> Sair</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
            </div>
        </div>
        <div class="col-md-2">
            <x-sidebar />
        </div>
        <div class="col-md-10">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')


    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("closem")[0];

        // Abre o modal quando o botão é clicado
        btn.onclick = function() {
            $('#myForm')[0].reset();
            document.getElementById("id").value = "";
            document.getElementById("address").disabled = false;
            document.getElementById("city").disabled = false;
            document.getElementById("state").disabled = false;
            document.getElementById("district").disabled = false;
            document.getElementById("updateBtn").style.display = "none";
            document.getElementById("registerBtn").style.display = "block";
            habilitarFormulario();
            modal.style.display = "block";
        }

        // Fecha o modal quando o botão (x) é clicado
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Fecha o modal quando clicar fora dele
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function getUserData(id, update) {

            if (!update) {
                desabilitarFormulario();
                document.getElementById("registerBtn").style.display = "none";
                document.getElementById("updateBtn").style.display = "none";
            } else {
                habilitarFormulario();
                document.getElementById("updateBtn").style.display = "block";
                document.getElementById("registerBtn").style.display = "none";
            }

            $.ajax({
                url: 'api/users/' + id,
                method: 'GET',
                success: function(userData) {

                    $('#id').val(userData.id);
                    $('#name').val(userData.name);
                    $('#email').val(userData.email);
                    $('#address').val(userData.address);
                    $('#city').val(userData.city);
                    $('#state').val(userData.state);
                    $('#cep').val(userData.cep);
                    $('#number').val(userData.number);
                    $('#complement').val(userData.complement);
                    $('#district').val(userData.district);
                    $('#birthday').val(userData.birthday);
                    $('#cpf').val(userData.cpf);
                    $('#phone').val(userData.phone);

                    document.getElementById("check1").checked = userData.active == 1 ? true : false;

                    modal.style.display = "block";
                }
            });
        };


        document.getElementById("myForm").onsubmit = function(e) {

            e.preventDefault();

            var id = document.getElementById("id").value;
            var form = $('#myForm').serializeArray();

            form = form.filter(i => i.name !== 'id');

            const cpf = form.find(i => i.name === 'cpf').value;

            if (!validarCPF(cpf)) {
                alert("CPF inválido");
                return;
            }

            form.push({
                name: 'address',
                value: document.getElementById("address").value
            });
            form.push({
                name: 'city',
                value: document.getElementById("city").value
            });
            form.push({
                name: 'state',
                value: document.getElementById("state").value
            });
            form.push({
                name: 'district',
                value: document.getElementById("district").value
            });

            if (id) {
                $.ajax({
                    url: 'api/users/' + id,
                    method: 'PUT',
                    data: form,
                    success: function(userData) {
                        modal.style.display = "none";
                        var table = $('#usersTable').DataTable().ajax.reload()
                    }
                });
            } else {

                $.ajax({
                    url: 'api/users/',
                    method: 'POST',
                    data: form,
                    success: function(userData) {
                        modal.style.display = "none";
                        $('#usersTable').DataTable().ajax.reload()
                    }
                });
            }

        }

        function confirmDelete(id) {
            const confirmation = confirm("Tem certeza que deseja excluir este registro?");

            if (confirmation) {
                deleteUser(id);
            }
        }

        function deleteUser(id) {

            $.ajax({
                url: 'api/users/' + id,
                method: 'DELETE',
                success: function() {
                    var table = $('#usersTable').DataTable().ajax.reload()
                }
            });
        }

        //validar o cpf
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');

            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
                return false;
            }


            function calcularDigito(base) {
                let soma = 0;
                for (let i = 0; i < base.length; i++) {
                    soma += base[i] * ((base.length + 1) - i);
                }
                const resto = (soma * 10) % 11;
                return resto === 10 || resto === 11 ? 0 : resto;
            }

            const baseCPF = cpf.slice(0, 9);
            const primeiroDigito = calcularDigito(baseCPF);
            const segundoDigito = calcularDigito(baseCPF + primeiroDigito);


            return cpf === baseCPF + primeiroDigito + segundoDigito;
        }

        function consultarCep() {
            const cep = document.getElementById("cep").value;
            const url = `https://viacep.com.br/ws/${cep}/json/`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.logradouro) {
                        document.getElementById("address").value = data.logradouro;
                        document.getElementById("address").disabled = true
                    }
                    if (data.localidade) {
                        document.getElementById("city").value = data.localidade;
                        document.getElementById("city").disabled = true
                    }
                    if (data.uf) {
                        document.getElementById("state").value = data.uf;
                        document.getElementById("state").disabled = true
                    }
                    if (data.bairro) {
                        document.getElementById("district").value = data.bairro;
                        document.getElementById("district").disabled = true
                    }

                })
                .catch(error => console.error(error));
        }

        function desabilitarFormulario() {
            const form = document.getElementById('myForm');
            const elementos = form.elements;

            for (let i = 0; i < elementos.length; i++) {
                elementos[i].disabled = true;
            }
        }

        function habilitarFormulario() {
            const form = document.getElementById('myForm');
            const elementos = form.elements;

            for (let i = 0; i < elementos.length; i++) {
                elementos[i].disabled = false;
            }
        }
    </script>



</body>

</html>