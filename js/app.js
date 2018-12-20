let input = document.getElementById('file-input');
let infoArea = document.getElementById('file-upload-filename');
const imgUpload = document.querySelector('.imgUpload');
const myButton = document.querySelector('.myButton');
let i;
let correct = false;

input.addEventListener('change', showFileName);
myButton.addEventListener('click', verifInputValue);

// Permet l'affichage des fichiers insérés avec leurs infos (nom, taille, extention)



function showFileName(event) {

    // Fait disparaitre l'image d'upload
    imgUpload.style.display = 'none';

    correct = true;

    for (i = 0; i < input.files.length; i++) {

        let input = event.srcElement;

        // Affiche le nom des fichiers insérés
        let fileName = input.files[i].name; 

        // Affiche la taille des fichiers insérés
        let fileSize = input.files[i].size;

        // Converti octets en ko
        fileSize = Math.round(fileSize/1000);

        // Récupère l'extention du fichier
        let getExt = fileName.split('.').pop();

        // Injecte les infos récupérés dans la div ciblé
        infoArea.innerHTML += '<p class="files_content d-block mx-auto">' + fileName + '</p>';
        infoArea.innerHTML += '<p class="files_attribute d-block mx-auto">' + fileSize + ' ko' + ' | ' + getExt + '</p>';

        // Affecte une valeur a l'input
        

        
    }
}

// Permet de copier le lien injecté dans l'input text sur la page upload via le boutton
function copyLink() {

    let copyText = document.getElementById("inputLink");
  
    copyText.select();
  
    document.execCommand("copy");
  
    alert("Le lien a été copié dans le presse-papier !");
  }


function verifInputValue() {

    // Si la valeur de l'input n'est pas défini -> Retourne une alerte
    if (!correct) {

        swal("Attention !", "Merci d'ajouter vos fichiers avant d'envoyer !", "warning");
    }
}


