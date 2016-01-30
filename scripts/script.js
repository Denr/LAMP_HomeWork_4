$(document).ready(function () {
    $("#feedback").keydown(function (e) {
        var max = 200;
        var char = $("#char");
        var text = $("#feedback").val().length;
        if (text >= max) {
            if (e.keyCode === 8) {
                return;
            }
            char.html("You have reached the limit");
            e.preventDefault();
            return;
        }
        char.html("Characters left: " + (max - text));
    })
});