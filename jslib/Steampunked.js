function Steampunked(sel) {
    var leaks = $(sel + ' input[name=leak]');
    leaks.click(function(event) {
        event.preventDefault();
        $.ajax({
            url: "game-post.php",
            data: {leak: $(this).attr('value'), radio: $(sel + ' input[name=radio]:checked').val()},
            method: "POST",
            success: function(data) {
                var json = parse_json(data);
                if(json.ok) {
                    // Successfully updated
                    console.log(json.html);
                    console.log($(sel + ' .container'));
                    $('.container').replaceWith(json.html);
                } else {
                    // Update failed
                    $(sel + " .message").text(json.message);
                    $(that).removeClass("clicked");
                }
            },
            error: function(xhr, status, error) {
                // Error
                concole.log("error");
            }
        });
    });
}

function parse_json(json) {
    try {
        var data = $.parseJSON(json);
    } catch(err) {
        throw "JSON parse error: " + json;
    }

    return data;
}