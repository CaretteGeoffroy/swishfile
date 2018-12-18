let input = document.getElementById('file-input');
let infoArea = document.getElementById('file-upload-filename');
const imgUpload = document.querySelector('.imgUpload');
let i;

input.addEventListener('change', showFileName);

function showFileName(event) {

    imgUpload.style.display = 'none';

    for (i = 0; i < input.files.length; i++) {

        let input = event.srcElement;

        let fileName = input.files[i].name;

        infoArea.innerHTML += '<p class="files_content">' + fileName + '</p>';
    }
}
