function uploadhinh() {
    var input = document.getElementById('file_upload');
    var url = URL.createObjectURL(input.files[0]);
    image_upload.setAttribute('src', url);
}
function uploadhinh2() {
    var input = document.getElementById('file_upload2');
    var url = URL.createObjectURL(input.files[0]);
    image_upload2.setAttribute('src', url);
}
