<pessoa-form-dados>
    <fieldset>
        <legend>Dados</legend>
        <input type="hidden" name="id" value="{ dados.id }">
        <div class="columns">
            <div class="column col-2 col-md-12">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" name="status">
                        <option value="1" selected="{ 1 == dados.status }">Ativo</option>
                        <option value="0" selected="{ 0 == dados.status }">Inativo</option>
                    </select>
                </div>
            </div>
            <div class="column col-2 col-xs-12">
                <div class="form-group { errors.matricula ? 'has-error' : '' }">
                    <label class="form-label" for="matricula">Matricula</label>
                    <input class="form-input" type="text" maxlength="20" name="matricula" value="{ dados.matricula }"
                        placeholder="Número do Crachá">
                    <div class="form-input-hint" if="{ errors.matricula }" each="{ e in errors.matricula }">- { e }</div>
                </div>
            </div>
            <div class="column col-8 col-xs-12">
                <div class="form-group { errors.nome ? 'has-error' : '' }">
                    <label class="form-label" for="nome">Nome</label>
                    <input class="form-input" type="text" maxlength="100" name="nome" value="{ dados.nome }"
                        placeholder="Nome do Funcionário">
                    <div class="form-input-hint" if="{ errors.nome }" each="{ e in errors.nome }">- { e }</div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column col-4 col-xs-12">
                <div class="form-group { errors.empresas ? 'has-error' : '' }">
                    <label class="form-label" for="empresa_id">Empresa</label>
                    <form-autocomplete name="empresa_id" id="empresas" required="true" placeholder="Digite para pesquisar"
                        source="{ empresaSource }"></form-autocomplete>
                </div>
            </div>
            <div class="column col-4 col-xs-12">
                <div class="form-group { errors.cargos ? 'has-error' : '' }">
                    <label class="form-label" for="cargo">Cargo</label>
                    <form-autocomplete name="cargo_id" id="cargos" required="true" placeholder="Digite para pesquisar"
                        source="{ cargoSource }"></form-autocomplete>
                </div>
            </div>
            <div class="column col-4 col-xs-12">
                <div class="form-group { errors.departamentos ? 'has-error' : '' }">
                    <label class="form-label" for="departamento">Departamento</label>
                    <form-autocomplete name="departamento_id" id="departamentos" required="true" placeholder="Digite para pesquisar"
                        source="{ departamentoSource }"></form-autocomplete>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column col-4 col-xs-12">
                <div class="form-group { errors.email ? 'has-error' : '' }">
                    <label class="form-label" for="email">E-mail</label>
                    <input class="form-input" type="email" name="email" value="{ dados.email }" maxlength="100">
                    <div class="form-input-hint" if="{ errors.email }" each="{ e in errors.email }">- { e }</div>
                </div>
            </div>
            <div class="column col-4 col-xs-12">
                <div class="form-group { errors.fone ? 'has-error' : '' }">
                    <label class="form-label" for="fone">Telefone</label>
                    <input class="form-input fone" name="fone" value="{ dados.fone }" type="text" placeholder="(62) 9XXXX-XXXX">
                    <div class="form-input-hint" if="{ errors.fone }" each="{ e in errors.fone }">- { e }</div>
                </div>
            </div>
            <div class="column col-4 col-xs-12">
                <div class="form-group { errors.fone_2 ? 'has-error' : '' }">
                    <label class="form-label" for="fone_2">Celular</label>
                    <input class="form-input fone" name="fone_2" value="{ dados.fone_2 }" type="text" placeholder="(62) 9XXXX-XXXX">
                    <div class="form-input-hint" if="{ errors.fone_2 }" each="{ e in errors.fone_2 }">- { e }</div>
                </div>
            </div>
        </div>
    </fieldset>

    <script>
        var tag = this;
        tag.url = BASE_URL + '/pessoa';
        tag.dados = opts.dados || {};
        tag.errors = opts.errors || {};
        tag.errors.on('atualiza', function (newErrors) {
            tag.update({
                'errors': newErrors
            });
        });
        tag.empresaSource = empresaSource;
        tag.cargoSource = cargoSource;
        tag.departamentoSource = departamentoSource;

        tag.on('mount', onMount);

        function onMount() {
            _setMaskFone();
        }

        function _setMaskFone() {
            var telMask = ['(99) 9999-99999', '(99) 99999-9999'];
            var tel = document.querySelectorAll('.fone');
            VMasker(tel).maskPattern(telMask[0]);
            tel.forEach(function (el) {
                el.addEventListener('input', _inputHandler.bind(undefined, telMask, 14), false);
            });
        }

        function _inputHandler(masks, max, event) {
            var c = event.target;
            var v = c.value.replace(/\D/g, '');
            var m = c.value.length > max ? 1 : 0;
            VMasker(c).unMask();
            VMasker(c).maskPattern(masks[m]);
            c.value = VMasker.toPattern(v, masks[m]);
        }

        function empresaSource(callback) {
            Request.get(tag.url + '/buscar-empresas/', function (json) {
                if (tag.dados.empresa_id) {
                    json = json.map(function (e) {
                        if (tag.dados.empresa_id == e.id) {
                            e.selected = true;
                        }

                        return e;
                    });
                }
                callback(json, 'id', 'descricao');
            });
        }

        function cargoSource(callback) {
            Request.get(tag.url + '/buscar-cargos/', function (json) {
                if (tag.dados.cargo_id) {
                    json = json.map(function (e) {
                        if (tag.dados.cargo_id == e.id) {
                            e.selected = true;
                        }

                        return e;
                    });
                }
                callback(json, 'id', 'descricao');
            });
        }


        function departamentoSource(callback) {
            Request.get(tag.url + '/buscar-departamentos/', function (json) {
                if (tag.dados.departamento_id) {
                    json = json.map(function (e) {
                        if (tag.dados.departamento_id == e.id) {
                            e.selected = true;
                        }

                        return e;
                    });
                }
                callback(json, 'id', 'descricao');
            });
        }
    </script>
</pessoa-form-dados>