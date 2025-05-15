function verifierAuthentification()
{
    // appel du script verifLogin.php via ajax
    $.ajax({
        url: '../Controleurs/controleur_N.1.php',
        data: {
            "commande": 'verifLogMdp',
            "login": $("#login").val(),
            "mdp": $("#mdp").val()
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

$(document).ready(function ()
{
    // Gestion du click sur le bouton d'authentification
    $("#verifLogin").click(verifierAuthentification);
    // Gestion du clic sur le bouton de réinitialisation
    $("#reset").click(function ()
    {
        $("#pastille").removeClass();
        $("#pastille").toggleClass("badge text-bg-light");
    });
});

