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
                    $(sel).replaceWith(json.html);
                    new Steampunked(sel);
                } else {
                    // Update failed
                    concole.log("update failed");
                }
            },
            error: function(xhr, status, error) {
                // Error
                concole.log("error");
            }
        });
    });

    var inputs = $(sel + ' .option input');
    inputs.click(function(event) {
        if ($(this).val() == "New Game") {
            return;
        }
        event.preventDefault();
        var data = { 'ajax_name': 'services_list_table' };
        data[$(this).attr('name')] = $(this).val();
        data['radio'] = $(sel + ' input[name=radio]:checked').val();
        $.ajax({
            url: "game-post.php",
            data: data,
            method: "POST",
            success: function(data) {
                var json = parse_json(data);
                if(json.ok) {
                    // Successfully updated
                    $(sel).replaceWith(json.html);
                    new Steampunked(sel);
                } else {
                    // Update failed
                    concole.log("update failed");
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