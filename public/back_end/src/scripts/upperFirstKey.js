function upberFirstKey(){
    var str = document.getElementsByClassName('upper_val')[0].value;
    str = str.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
        return letter.toUpperCase();
    });
    document.getElementsByClassName('upper_val')[0].value=str;
}
