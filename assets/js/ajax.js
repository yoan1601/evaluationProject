function verifyPaiement(id_devis) {

    const montant = document.getElementById('montant'+id_devis).value;

    var xhr = newXhr();
    xhr.addEventListener("load", function () {

        var resultat = JSON.parse(xhr.responseText);
        console.log(resultat);
        // return chargeProduit;

    });

    //envoie du formulaire fictif
    xhr.open("POST", "/application/views/ajax/verify_paiement.php");
    //envoie du formulaire fictif
    const formHTML = document.createElement("form");
    //numero
    var input = document.createElement("input");
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'id_devis');
    input.value = id_devis;
    formHTML.appendChild(input);
    //idproduit
    input = document.createElement("input");
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'montant');
    input.value = montant;
    formHTML.appendChild(input);
    const formJSON = new FormData(formHTML);
    xhr.send(formJSON);
}

function newXhr() {
    var xhr;
    try {
        xhr = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (e) {
        try {
            xhr = new ActiveXObject('Microsoft.XMLHTTP');
        } catch (e2) {
            try {
                xhr = new XMLHttpRequest();
            } catch (e3) {
                xhr = false;
            }
        }
    }

    return xhr;
}
