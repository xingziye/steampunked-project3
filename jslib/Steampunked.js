function Steampunked(sel) {
    var leaks = $(sel + ' input[name=leak]');
    console.log(leaks);
    leaks.click(function(event) {
        event.preventDefault();
        console.log("clicked");
    });
}