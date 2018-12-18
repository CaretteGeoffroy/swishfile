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

        let fileSize = input.files[i].size;

        fileSize = Math.round(fileSize/1000);

        let getExt = fileName.split('.').pop();

        infoArea.innerHTML += '<p class="files_content d-block mx-auto">' + fileName + '</p>';
        infoArea.innerHTML += '<p class="files_attribute d-block mx-auto">' + fileSize + ' ko' + ' | ' + getExt + '</p>';
    }
}