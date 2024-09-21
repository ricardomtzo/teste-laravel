var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("closem")[0];

        // Abre o modal quando o botão é clicado
        btn.onclick = function() {
            $('#myForm')[0].reset();
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

        function getUserData(id) {

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


                    modal.style.display = "block";
                }
            });
        };


            document.getElementById("myForm").onsubmit = function(e) {

                e.preventDefault();
                //document.getElementById("myForm").submit();

                var id = document.getElementById("id").value;

                if (id) {
                    $.ajax({
                        url: 'api/users/' + id,
                        method: 'PUT',
                        data: $('#myForm').serializeArray(),
                        success: function(userData) {
                            modal.style.display = "none";
                            var table = $('#usersTable').DataTable().ajax.reload()
                        }
                    });
                } else {

                    $.ajax({
                        url: 'api/users/',
                        method: 'POST',
                        data: $('#myForm').serializeArray(),
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