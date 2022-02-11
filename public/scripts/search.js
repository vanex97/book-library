/* ------------- The result of the search in autocomplete list --------------*/
var callbackQueryMiniItemsSearch = function(res, text) {
    $('.loader').show();
    if (res.data.total.amount > 0) {
        var books = res.data.books;
        view.addMiniItemsSearch(pathUrl, books, text);
    } else {
        view.addMiniItemsSearch(pathUrl, [{
            id: 'no-cover',
            title: 'По запросу "' + text + '" ничего не найдено :(',
            author: 'Миллионы натренированных обезьян облазили всю библиотеку и не нашли ничего подходящего, что могло бы соответствовать Вашему запросу.'
        }]);
    }
    setTimeout(function() {
        $('.loader').hide();
    }, 200);
};

/*-------------------The message on the search result -----------------------*/
var msgResultSearchText = function(text, number_found) {
    $('.text_found').text('\"' + text + '\"');
    var titles = ['совпадение', 'совпадения', 'совпадений'];
    var cases = [2, 0, 1, 1, 1, 2];
    var coincidence = titles[(number_found % 100 > 4 && number_found % 100 < 20) ? 2 :
        cases[(number_found % 10 < 5) ? number_found % 10 : 5]];

    $('.number_found').text(number_found + " " + coincidence);
};



