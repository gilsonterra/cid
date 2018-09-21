window.Serialize = {
    toArray: function (form) {
        var field, l, s = [];
        if (typeof form == 'object' && form.nodeName == "FORM") {
            var len = form.elements.length;
            for (var i = 0; i < len; i++) {
                field = form.elements[i];
                if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
                    if (field.type == 'select-multiple') {
                        l = form.elements[i].options.length;
                        for (j = 0; j < l; j++) {
                            if (field.options[j].selected)
                                s[s.length] = {
                                    name: field.name,
                                    value: field.options[j].value
                                };
                        }
                    } else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
                        s[s.length] = {
                            name: field.name,
                            value: field.value
                        };
                    }
                }
            }
        }
        return s;
    },

    toJson: function (form) {
        var json = {};
        var array = this.toArray(form);

        array.map(function (item) {
            if (item.name in json) {
                if (Array.isArray(json[item.name])) {
                    json[item.name].push(item.value);
                } else {
                    json[item.name] = [json[item.name], item.value];
                }
            } else {
                json[item.name] = item.value;
            }
        });

        return json;
    }
};