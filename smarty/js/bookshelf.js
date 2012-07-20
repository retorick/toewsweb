$(document).ready(function() {
    $('.more').click(function() {
        var ndx = this.id.substr(5);
        $('#thoughts_' + ndx).fadeIn(1000);
    });

    $('.thoughts_masthead img').click(function() {
        $(this).parent().parent().parent().css('display', 'none');
    });
});

