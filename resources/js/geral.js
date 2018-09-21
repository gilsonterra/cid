var APP = {};

/**
 * Pega data atual em pt_br. Ex: 13/01/1988
 */
APP.dataAtualPtBr = function () {
    var today = new Date();
    var dd = today.getDate();

    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }

    return dd + '/' + mm + '/' + yyyy;
}

/**
 * Seta a sessão no localstorage
 * 
 * @param {object} data 
 */
APP.setSession = function (data) {
    window.localStorage.setItem('session', JSON.stringify(data));
}

/**
 * Pega a sessão do local storage
 */
APP.getSession = function () {
    var session = window.localStorage.getItem('session');
    return session ? JSON.parse(session) : {};
}

APP.escapeTwigJsonParse = function (reponse) {
    var result = reponse.replace(/&quot;/g, '"').replace(/(?:\r\n|\r|\n)/g, '');
    return JSON.parse(result);
}

/**
 * Carrega arquivos assincrono e dinâmicamente
 */
APP.load = (function () {    
    function _load(tag) {
        return function (url) {            
            return new Promise(function (resolve, reject) {
                var element = document.createElement(tag);
                var parent = 'body';
                var attr = 'src';

                element.onload = function () {
                    resolve(url);
                };
                
                element.onerror = function () {
                    reject(url);
                };
                
                switch (tag) {
                    case 'script':
                        element.async = true;
                        break;
                    case 'link':
                        element.type = 'text/css';
                        element.rel = 'stylesheet';
                        attr = 'href';
                        parent = 'head';
                }

                element[attr] = url;
                document[parent].appendChild(element);
            });
        };
    }

    return {
        css: _load('link'),
        js: _load('script'),
        img: _load('img')
    }
})();


