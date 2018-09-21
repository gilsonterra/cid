<form-select-uf>
    <div class="columns">
        <div class="column col-2 col-md-12">
            <div class="form-group">
                <label class="form-label" for="{ opts.ufName }">UF</label>
                <select onchange="{ onChange }" name="{ opts.ufName }" ref="uf" class="form-select">
                    <option value=""></option>
                    <option each="{ estados }" value="{ uf }">{ uf }</option>
                </select>
            </div>
        </div>
        <div class="column col-4 col-md-12">
            <div class="form-group">
                <label class="form-label" for="{ opts.municipioName }">Município</label>
                <select name="{ opts.municipioName }" class="form-select" ref="municipio">
                    <option value=""></option>
                    <option each="{ municipios }" value="{ cod_ibge }">{ nome_municipio }</option>
                </select>
            </div>
        </div>
        <div class="column col-6 col-md-12">
            <div class="form-group">
                <label class="form-label" for="{ opts.enderecoName }">Endereço</label>
                <input type="text" name="{ opts.enderecoName }" maxlength="150" value="{ opts.enderecoVal }" class="form-input">
            </div>
        </div>
    </div>
    <script>
        var tag = this;
        tag.municipios = [];
        tag.codIbge = tag.opts.codIbge || null;
        tag.estados = [{
                'uf': 'AC',
                'nome': 'Acre'
            },
            {
                'uf': 'AL',
                'nome': 'Alagoas'
            },
            {
                'uf': 'AM',
                'nome': 'Amazonas'
            },
            {
                'uf': 'AP',
                'nome': 'Amapá'
            },
            {
                'uf': 'BA',
                'nome': 'Bahia'
            },
            {
                'uf': 'CE',
                'nome': 'Ceara'
            },
            {
                'uf': 'DF',
                'nome': 'Distrito Federal'
            },
            {
                'uf': 'ES',
                'nome': 'Espírito Santo'
            },
            {
                'uf': 'GO',
                'nome': 'Goiás'
            },
            {
                'uf': 'MA',
                'nome': 'Maranhão'
            },
            {
                'uf': 'MG',
                'nome': 'Minas Gerais'
            },
            {
                'uf': 'MS',
                'nome': 'Mato Grosso do Sul'
            },
            {
                'uf': 'MT',
                'nome': 'Mato Grosso'
            },
            {
                'uf': 'PA',
                'nome': 'Pará'
            },
            {
                'uf': 'PB',
                'nome': 'Paraíba'
            },
            {
                'uf': 'PE',
                'nome': 'Pernambuco'
            },
            {
                'uf': 'PI',
                'nome': 'Piauí'
            },
            {
                'uf': 'PR',
                'nome': 'Paraná'
            },
            {
                'uf': 'RJ',
                'nome': 'Rio de Janeiro'
            },
            {
                'uf': 'RN',
                'nome': 'Rio Grande do Norte'
            },
            {
                'uf': 'RO',
                'nome': 'Rondônia'
            },
            {
                'uf': 'RR',
                'nome': 'Roraima'
            },
            {
                'uf': 'RS',
                'nome': 'Rio Grande do Sul'
            },
            {
                'uf': 'SC',
                'nome': 'Santa Catarina'
            },
            {
                'uf': 'SE',
                'nome': 'Sergipe'
            },
            {
                'uf': 'SP',
                'nome': 'São Paulo'
            },
            {
                'uf': 'TO',
                'nome': 'Tocantins'
            }
        ];
        tag.on('mount', onMount);
        tag.onChange = onChange;

        function onChange(event) {
            var data = {
                'uf_municipio': event.target.value
            };
            Request.post(BASE_URL + '/municipio/buscar', JSON.stringify(data),
                function (json) {
                    tag.update({
                        'municipios': json
                    });
                }
            );
        }

        function onMount() {
            if (tag.codIbge) {
                var data = {
                    'cod_ibge': tag.codIbge
                };
                Request.post(BASE_URL + '/municipio/buscar', JSON.stringify(data),
                    function (json) {
                        var selected = json[0];
                        var data = {
                            'uf_municipio': selected.uf_municipio
                        };
                        Request.post(BASE_URL + '/municipio/buscar', JSON.stringify(data),
                            function (json) {
                                tag.update({
                                    'municipios': json
                                });

                                tag.refs.uf.value = selected.uf_municipio;
                                tag.refs.municipio.value = selected.cod_ibge;
                            }
                        );
                    }
                );
            }
        }
    </script>
</form-select-uf>