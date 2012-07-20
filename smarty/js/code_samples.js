var RT = window.RT || {};

RT.isIE = function() {
    return navigator.appName.match(/Microsoft/) ? true : false;
};


RT.openWindow = function(params) {
    var url = params.url || 'https://raw.github.com/arithmophile/number-functions-api/master/api_functions/functions.php';
    var pWidth = params.pWidth || 1024;
    var pHeight = params.pHeight || 768;
    var cWidth = params.cWidth || 800;
    var cHeight = params.cHeight || 600;

    var x = Math.floor(.5 + (pWidth - cWidth) / 2);
    var y = Math.floor(.5 + (pHeight - cHeight) / 2);

    var winAttr = [
        'screenX=' + x,
        'screenY=' + y,
        'left=' + x,
        'top=' + y,
        'width=' + cWidth,
        'height=' + cHeight,
        'scrollbars'
    ];
    var attr = winAttr.join();
    var myWin = open(url, "myWin", attr);
};


/*
    CS:  Code Samples JavaScript namespace/object
*/
CS = window.CS || {

    initDescShow: function() {
    },

    initDescHide: function() {
    },

    openSample: function(url) {
        var winParams = {
            url:        url || 'http://www.google.com',
            pWidth:     window.innerWidth,
            pHeight:    window.innerHeight,
            cWidth:     Math.floor(.5 + window.innerWidth * .75),
            cHeight:    Math.floor(.5 + window.innerHeight * .75)
        };

        RT.openWindow(winParams);
    }
};


