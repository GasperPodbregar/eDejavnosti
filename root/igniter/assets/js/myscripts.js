
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
$(document).ready(function(){
    $('#txt_sola').multiselect({
        nonSelectedText:'Izberite šole',
        buttonWidth:'400px'
    });
});

$(document).ready(function(){
    $('#txt_dijaki').multiselect({
    nonSelectedText: "Izberite dijake, ki jih želite prijaviti na dejavnost",
    buttonWidth:"400px"
    });
});

    var st = "<?php echo $dijaki[0]["."moznaMesta"."]; ?>";
    var verified = [];
    document.querySelector('select').onchange = function(e) {
        if (this.querySelectorAll('option:checked').length <= st) {
            verified = Array.apply(null, this.querySelectorAll('option:checked'));
        } else {
        Array.apply(null, this.querySelectorAll('option')).forEach(function(e) {
            e.selected = verified.indexOf(e) > -1;
        });
      }
    }