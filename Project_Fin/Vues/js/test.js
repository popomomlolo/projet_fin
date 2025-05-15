function remplirScore()
{
    $.getJSON('../Controleurs/controleur.php',
            {
                'commande': 'getScore'
            })
            .done(function (donnees, stat, xhr) {
                console.log("val retour : "+donnees );
                $("#tab_score_user").text(donnees);
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function remplirTable(e)
{

    e.preventDefault();
    var nomDeLaVille = $("#ville").val();
    $.getJSON('../Controleurs/controleur.php', 
					{commande: 'getDepartementsPourVille',
        					 nomVille: nomDeLaVille})
            .done(function (donnees, stat, xhr) {
               //detruire le datatable s'il existe déjà
                if ($.fn.dataTable.isDataTable('#deptVille')) {
                    $('#deptVille').DataTable().clear().destroy();
                }
                // création du datatable
                var table=$('#deptVille').DataTable(
                        {
                            "data": donnees,

                            "columns": [
                                {title: "ville"},
                                {title: "Code postal"},
                                {title: "departement"}
                            ],
                         "lengthMenu": [[5, 10, 15, 25, 50, 100, -1], [5, 10, 15, 25, 50, 100, "Tous"]],
                         "pageLength": 5,
                         "language": {
                              "lengthMenu": "Afficher _MENU_ lignes par page",
                              "info": "page _PAGE_ sur _PAGES_",
                              "infoEmpty": "pas de résultat",
                              "search": "Recherchez: ",
                                "paginate": {
                                    "first": "Premier ",
                                    "last": "Dernier ",
                                    "next": "Suivant ",
                                    "previous": "Précédent "
                                },
                            }
                        }
                );
                // Ajuster la largeur des colonnes
                table.columns.adjust().draw();
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            })
}

$(document).ready(function () {
    remplirScore();
    $('form').submit(remplirTable);
});
