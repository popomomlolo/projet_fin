function verifierReponse()
{
    // appel du script verifLogin.php via ajax
    $.ajax({
        url: '../Controleurs/controleur_N.1.php',
        data: {
            "commande": 'verifReponse',
            "login": $("#login").val(),
            "reponse": $("#reponse").val()
        },
        type: 'POST',
        dataType: 'json',
        success: // si la requete fonctionne, mise à jour de la couleur de pastille
                function (donnees, status, xhr) {

                    $("#pastille").removeClass();
                    switch (donnees) {
                        case 'v':
                            $("#pastille").toggleClass("badge text-bg-success");
                            break;
                        case 'r':
                            $("#pastille").toggleClass("badge text-bg-danger");
                            break;
                            case 'o':
                            $("#pastille").toggleClass("badge text-bg-warning");
                            break;
                    }
                },
        error:
                function (xhr, status, error) {
                    console.log("param : " + JSON.stringify(xhr));
                    console.log("status : " + status);
                    console.log("error : " + error);

                }
    });
}

function afficherQuestion()
{
    var idUser = $(this).val(); // on récupère la valeur de l'option de la liste
    $("#question").empty(); // vider la zone de texte
    if (idUser !== '-1') { // si l'utilisateur n'est pas le premier (choisissez....)

        $.ajax({
            url: '../Controleurs/controleur.php',
            data: {
                "commande": 'obtenirQuestion',
                "idUser": idUser
            },
            type: 'POST',
            dataType: 'json',
            success:
                    function (donnees, stat, xhr) {
                        //$("#adresse").text(donnees.adresse);
                        $("#question").text(donnees);
                    },
            error:
                    function (xhr, text, error) {
                        console.log("param : " + JSON.stringify(xhr));
                        console.log("status : " + text);
                        console.log("error : " + error);
                    }});
    }
}

function genererListeQuestion() 
{
    $.ajax({
        url: '../Controleurs/controleur.php',
        data: {
            "commande": 'listeQuestion'
        },
        type: 'GET',
        dataType: 'json',
        success:
                function (donnees, stat, xhr) {
                    // génération de la liste déroulante des utilisateurs
                    $("#listeQuestion").append($('<option>', {value: -1}).text("Sélectionnez une question"));
                    $.each(donnees, function (index, ligne) {
                        // ligne contient un objet json de la forme
                        // {"id" : "id de la personne"},
                        // {"nom" : "nom de la personne"}                        
                        var utilisateur = ligne.type_question;
                        $("#listeQuestion").append($('<option>', {value: ligne.id}).text(utilisateur));
                    });
                },
        error:
                function (xhr, text, error) {
                    console.log("param : " + JSON.stringify(xhr));
                    console.log("status : " + text);
                    console.log("error : " + error);
                }});
}

$(document).ready(function ()
{
    genererListeQuestion();
    // Gestion du click sur le bouton d'authentification
    $("#verifLogin").click(verifierReponse);
    // Gestion du clic sur le bouton de réinitialisation
    $("#reset").click(function ()
    {
        $("#pastille").removeClass();
        $("#pastille").toggleClass("badge text-bg-light");
    });
    $("#listeQuestion").change(afficherQuestion);
});
