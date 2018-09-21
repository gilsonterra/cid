<pessoa-form>
    <form onsubmit="{ onSubmit }">
        <div class="card">
            <div class="card-header">
                <div class="card-title h3">
                    <div class="float-left">Cadastro Pessoa</div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary mr-1">Salvar</button>
                        <a href="{ url }/listar" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <pessoa-form-dados errors="{ errors }" dados="{ dados }"></pessoa-form-dados>
                <pessoa-form-veiculos errors="{ errors }" veiculos="{ dados.veiculos }"></pessoa-form-veiculos>
                <pessoa-form-ocorrencias errors="{ errors }" veiculos="{ dados.ocorrencias }"></pessoa-form-ocorrencias>
            </div>
        </div>
    </form>
    <script>
        var tag = this;
        tag.url = BASE_URL + '/pessoa';
        tag.errors = riot.observable({});
        tag.dados = opts.dados || {};
        tag.id = opts.dados ? opts.dados.id : '';
        tag.onSubmit = onSubmit;

        function _trataDados(data) {
            var veiculos = [];
            var veiculosInseridos = [];
            for (var i in data) {
                if (data.hasOwnProperty(i) && i.indexOf("veiculos_") == 0) {
                    var indice = i.split('_')[1];

                    if (veiculosInseridos.indexOf(indice) < 0) {
                        veiculosInseridos.push(indice);
                        veiculos.push({
                            'id': data['veiculos_' + indice + '_id'] || null,
                            'identificador': data['veiculos_' + indice + '_identificador'],
                            'placa': data['veiculos_' + indice + '_placa'],
                            'cor': data['veiculos_' + indice + '_cor'],
                            'modelo': data['veiculos_' + indice + '_modelo'],
                        });
                    }

                    delete data[i];
                }
            }

            data['veiculos'] = veiculos;
            return data;            
        }

        function onSubmit(event) {
            event.preventDefault();
            var form = event.target;
            var data = _trataDados(Serialize.toJson(form));            

            Request.post(tag.url + '/persistir/' + tag.id, JSON.stringify(data),
                function (json) {
                    if (json.message) {
                        swal(json.message).then(function () {
                            if (json.message.type == 'success') {
                                window.location.href = tag.url + '/listar';
                            }
                        });
                    }

                    tag.errors.trigger('atualiza', json.errors);
                });
        }
    </script>
</pessoa-form>