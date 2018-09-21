<login>
    <div class="container-login container grid-xs">
        <p class="h2">
            <b>Estacionamento</b> - Sistema de controle do estacionamento
        </p>
        <form onsubmit="{ onSubmit }">
            <div class="card">
                <div class="card-header">
                    <div class="card-title h3">
                        <div class="float-left">Login</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="columns">
                        <div class="column col-12 col-md-12">
                            <div class="form-group { errors.login ? 'has-error' : '' }">
                                <label class="form-label" for="login">Usuário</label>
                                <input type="text" name="login" maxlength="100" autocomplete="off" class="form-input" autofocus required>
                                <div class="form-input-hint" if="{ errors.login }" each="{ e in errors.login }">- { e }</div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column col-12 col-md-12">
                            <div class="form-group { errors.senha ? 'has-error' : '' }">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="password" name="senha" maxlength="20" autocomplete="off" class="form-input" required>
                                <div class="form-input-hint" if="{ errors.senha }" each="{ e in errors.senha }">- { e }</div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column col-12 col-md-12">
                            <button type="submit" class="btn btn-primary mr-1">Entrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        var tag = this;
        tag.url = BASE_URL + '/login';
        tag.errors = opts.errors || {};        
        tag.onSubmit = onSubmit;         

        function onSubmit(event) {
            event.preventDefault();
            APP.setSession({});    
            
            var form = event.target;
            var data = Serialize.toJson(form);

            Request.post(tag.url + '/login/', JSON.stringify(data),
                function (json) {
                    if (json.message) {
                        if (json.message.type == 'success') {                            
                            APP.setSession(json.message.data.usuario_sessao);                          
                            window.location.href = BASE_URL + '/pessoa/listar';
                        }
                        else{
                            swal(json.message);
                        }                        
                    }

                    if (json.errors) {
                        tag.update({
                            'errors': json.errors
                        });
                    }
                });
        }
    </script>
</login>