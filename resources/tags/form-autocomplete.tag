<form-autocomplete>
    <select id="form-autocomplete-{ opts.id }"  placeholder="{ opts.placeholder }" multiple="{ opts.multiple }" name="{ opts.name }" class="form-select">
    </select>
    <script>
        var tag = this;
        tag.onBlur = opts.onBlur || null;
        tag.on('mount', onMount);

        function onMount() {
            var element = document.getElementById('form-autocomplete-' + tag.opts.id);            
            var options = {
                loadingText: 'Carregando...',
                itemSelectText: '',
                noResultsText: 'Nenhum resultado encontrado',
                noChoicesText: 'Nenhuma opção',
                removeItemButton: true,
                addItemText: function (value) {
                    return 'Clique para adicionar <b>"${value}"</b>';
                }
            };

            var choices = new Choices(element, options);
            choices.ajax(tag.opts.source);       

            if (tag.opts.disabled) {
                choices.disable();
            }
        }
    </script>
</form-autocomplete>