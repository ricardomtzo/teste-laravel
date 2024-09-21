<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">

                <div class="alert alert-success" style="display: none" id="successAlert" role="alert">
                    Login realizado com sucesso.
                </div>

                <div class="alert alert-danger" style="display: none" id="errorAlert" role="alert">
                    Email ou senha inválidos.
                </div>

                <div class="card">

                    <div class="card-header">{{__('Login')}}</div>

                    <div class="card-body">
                        <form method="POST" action="api/login">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="InputEmail">Endereço de email</label>
                                <input type="email" name="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Seu email" autofocus>
                                <!--<small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>-->
                            </div>
                            <div class="form-group mb-3">
                                <label for="InputPassword">Senha</label>
                                <input type="password" name="password" class="form-control" id="InputPassword" placeholder="Senha">
                            </div>
                            <div class="form-group form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="check1">
                                <label class="form-check-label" for="check1">Clique em mim</label>
                            </div>
                            <button type="button" onclick="login()" class="btn btn-primary">Enviar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

@stack('scripts')

<script>
    function login() {

        const email = document.getElementById("InputEmail").value;
        const password = document.getElementById("InputPassword").value;
        const url = `api/login`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status) {
                    document.getElementById("successAlert").style.display = "block";
                    setTimeout(()=> {
                        window.location.href = 'dashboard';
                    },2000)
                } else {
                    document.getElementById("errorAlert").style.display = "block";
                    document.getElementById("errorAlert").innerHTML = data.message
                    setTimeout(()=> {
                        document.getElementById("errorAlert").style.display = "none";
                    },2000)
                }
            })
    }
</script>

</html>