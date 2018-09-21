<pessoa-form-veiculos>
    <fieldset>
        <legend>
            <div class="float-left">Veículos</div>
            <div class="float-right">
                <button type="button" onclick="{ adicionarVeiculo }" class="btn btn-link">
                    <i class="icon icon-plus"></i>
                    Adicionar
                </button>
            </div>
        </legend>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 20%">Identificador</th>
                    <th style="width: 20%">Placa</th>
                    <th style="width: 20%">Cor</th>
                    <th style="width: 30%">Modelo</th>
                    <th style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                <tr if="{ veiculos }" each="{ v, index in veiculos }">
                    <td>
                        <input class="form-input" type="text" name="veiculos_{index}_identificador" maxlength="20" value="{ v.identificador }" placeholder="Número do Adesivo">
                    </td>
                    <td>
                        <input class="form-input placa" type="text" name="veiculos_{index}_placa" onblur="{ buscaPlaca }" maxlength="8" value="{ v.placa }" placeholder="Placa do Veículo"
                            autocomplete="off">
                    </td>
                    <td>
                        <input class="form-input" type="text" name="veiculos_{index}_cor" maxlength="100" value="{ v.cor }">
                    </td>
                    <td>
                        <input class="form-input" type="text" maxlength="200" name="veiculos_{index}_modelo" value="{ v.modelo }">
                    </td>
                    <td>
                        <button type="button" class="btn btn-error" onclick="{ removerVeiculo }">
                            Remover
                        </button>
                    </td>
                </tr>
                <tr if="{ veiculos.length <= 0 }">
                    <td colspan="5">Nenhum veículo cadastrado.</td>
                </tr>
            </tbody>
        </table>
    </fieldset>

    <script>
        var tag = this;
        tag.url = BASE_URL + '/pessoa';
        tag.errors = opts.errors || {};
        tag.errors.on('atualiza', function (newErrors) {
            tag.update({
                'errors': newErrors
            });
        });
        tag.veiculos = opts.veiculos || [];
        tag.buscaPlaca = buscaPlaca;
        tag.adicionarVeiculo = adicionarVeiculo;
        tag.removerVeiculo = removerVeiculo;        

        function adicionarVeiculo(event) {
            var newVeiculo = {
                identificador: '',
                placa: '',
                cor: '',
                modelo: ''

            };

            tag.veiculos.push(newVeiculo);
            tag.update();

            VMasker(document.querySelectorAll('.placa')).maskPattern('AAA-9999');
        }

        function removerVeiculo(event) {
            tag.veiculos.some(function (veiculo) {
                if (event.item.v === veiculo) {
                    tag.veiculos.splice(tag.veiculos.indexOf(veiculo), 1);
                }
            });

            tag.update();
        }

        function buscaPlaca(event) {
            var placa = event.target.value;

            if (placa) {
                Request.get(tag.url + '/buscar-placa/' + placa, function (json) {
                    var veiculosUpdated = tag.veiculos.map(function (veiculo) {
                        if (json && event.item.v === veiculo) {
                            veiculo = event.item.v;
                            veiculo.cor = json.cor;
                            veiculo.modelo = json.modelo;
                        }

                        return veiculo;
                    });

                    tag.update({
                        'veiculos': veiculosUpdated
                    });
                });
            }
        }
    </script>
</pessoa-form-veiculos>