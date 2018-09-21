riot.mixin('ListagemMixin', {
    urlFetch: null,

    onSearch(event) {
        event.preventDefault();
        this.onRequest();
    },

    onPrev(event) {
        event.preventDefault();
        this.onRequest(this.grid.prev_page_url);
    },

    onNext(event) {
        event.preventDefault();
        this.onRequest(this.grid.next_page_url);
    },

    callbackBeforeRequest: function () {
        return true;
    },

    callbackOnRequest: function (json) {
        this.update({
            'grid': json,
            'loading': false
        });
    },

    onRequest(pageUrl) {
        var self = this;
        var pageUrl = pageUrl ? pageUrl : '';
        var form = this.refs.formulario;
        var data = Serialize.toJson(form);
        data.paginate = true;

        if (this.callbackBeforeRequest()) {
            Request.post(this.urlFetch + pageUrl, JSON.stringify(data), function (json) {
                self.callbackOnRequest(json);
            });
        }
    }
});