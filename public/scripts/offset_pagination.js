/**
 * Add or set uri parameter.
 * @param params Established uri parameters.
 * @param key Setting parameter key.
 * @param value Setting parameter value.
 * @returns {*} Uri with set parameter.
 */
function setUriParameter(params ,key, value) {
    if (params.has(key)) {
        params.set(key, value);
        return params;
    }
    params.append(key, value);
    return params;
}


let url = new URL(document.URL);
let params = new URLSearchParams(url.search);

$("#previous-button").click(function () {
    let assignUri = setUriParameter(params, 'offset', offsetValue - limit);
    if (assignUri.get('offset') === '0') {
        assignUri.delete('offset');
    }
    if (assignUri.toString() === '' || assignUri.get('offset') < 0) {
        assignUri = url.toString().split('?')[0];
    }
    else {
        assignUri = "?" + assignUri;
    }
    window.location.assign(assignUri);
});

$("#next-button").click(function () {
    window.location.assign("?" + setUriParameter(params, 'offset', offsetValue + limit));
});