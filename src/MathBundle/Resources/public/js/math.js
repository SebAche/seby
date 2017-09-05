$(document).ready(function () {
    $('#id_table_joueur').DataTable();
    $('#id_table_resultatPartie').DataTable();
    $('#id_table_listePartie').DataTable();

    tempsRestant();
    ajoutCaraReponse();
    validation();
    del();
    skill();
});

var intervalCompteur;
var intervalDuree;

function finQuestion() {
    // affichage résultat
    afficherResultat();
    clearInterval(intervalCompteur);
    clearInterval(intervalDuree);
//    sleep(5000);
    setTimeout(function(){

    $('#form').closest("form").submit();
}, 2000);
//    console.log('On valide le form maitenant !');

}

function validation() {
    $(".validation").click(function () {

        finQuestion();

    });
}

function skill(){
    $('.skill').on('load', function () {
    var skillBar = $(this).siblings().find('.inner');
    var skillVal = skillBar.attr("data-progress");
    $(skillBar).animate({
        height: skillVal
    }, 1500);
});
}

function afficherResultat(){
    var spanResultatCorrect = $('.resco');
    var spanReponseAffichee = $('#reponseAffichee');
    
    if (spanResultatCorrect.text() === spanReponseAffichee.text()){
        $('#bonneReponse').removeClass('hidden');
//        alert('ok');
    } else {
        $('#mauvaiseReponse').removeClass('hidden');
        $('#hiddenResco').removeClass('hidden');
//        alert('ko');
    }
}



function tempsRestant() {
    var spanCompteur = $('#temps_restant');
    var divCompteur = spanCompteur.parent();
    var tpsAffiche = spanCompteur.text();
    var sec_passee = 0;
    

    intervalCompteur = setInterval(function () {
        tpsAffiche--;
        spanCompteur.empty();
        spanCompteur.append(tpsAffiche);
        sec_passee++;
        $('#form_tempsPasse').attr('value', sec_passee);

        switch (tpsAffiche) {
            case 6:
                divCompteur.removeClass('alert-success');
                divCompteur.addClass('alert-warning');
                break;
            case 3:
                divCompteur.removeClass('alert-warning');
                divCompteur.addClass('alert-danger');
                break;
            case 0:
                finQuestion();
                break;
        }
    }, 1000);

}



//function tempsPasse() {
//    
//    
//    
//    var sec_passee = 0;
//    intervalDuree = setInterval(function () {
//        sec_passee++;
//        $('#form_tempsPasse').attr('value', sec_passee);
//    }, 1000);
//}

function ajoutCaraReponse() {
    var inputReponse = $('#form_resultatDonne');

    $(".caraReponse").click(function () {
        var valeurButton = $(this).text();
        valDejaPresente = inputReponse.val();
        inputReponse.attr('value', valDejaPresente + valeurButton);
        
        var pReponseAffichee = $('#reponseAffichee');
        pReponseAffichee.html(valDejaPresente + valeurButton);
    });
}

function del() {
    var inputReponse = $('#form_resultatDonne');
    $(".del").click(function () {

        var valeurPresente = inputReponse.val();
        if (valeurPresente.length > 0) {
            var nbCara = valeurPresente.length;
            inputReponse.attr('value', valeurPresente.substring(0, nbCara - 1));
            
            var pReponseAffichee = $('#reponseAffichee');
            pReponseAffichee.html(valeurPresente.substring(0, nbCara - 1));

        }

    });
}

nbAffiche = 0;
nbOccurence = 0;
inter = null;

function testSeb() {
    var divDuFooter = $('.test_js');
    divDuFooter.append('<p class="pHeure">Il est <span class="sHeure"></span> !</p>');
    divDuFooter.append('<button class="btn btn-success btn_switch btn-lg">Start</button>');

    $(".btn_switch").click(function () {
        if (nbOccurence === 0) {
            divDuFooter.append('<div class="seb bd-callout bd-callout-warning" >0</div><button id="clear" class="btn btn-info btn-lg">Clear</button>');
            $("#clear").click(clickClear);
            nbOccurence++;
        }


        if ($(".btn_switch").html() === 'Start') {

            inter = setInterval(function () {
                nbAffiche++;
                $('.seb').empty();
                $('.seb').append(nbAffiche);
            }, 1000);
            $(".btn_switch").html('Stop');
            $(".btn_switch").removeClass('btn-success');
            $(".btn_switch").addClass('btn-danger');
        } else {
            clearInterval(inter);
            $(".btn_switch").html('Start');
            $(".btn_switch").removeClass('btn-danger');
            $(".btn_switch").addClass('btn-success');
        }
    });

}

function clickClear() {
    if ($(".btn_switch").html() === 'Stop') {
        $(".btn_switch").html('Start');
    }
    clearInterval(inter);
    nbAffiche = 0;
    nbOccurence = 0;
    $('.seb').remove();
    $('#clear').remove();
}

function heureSeb() {
    setInterval(function () {
        var today = new Date();
        var h = today.getHours();

        if (h < 10) {
            h = "0" + h
        }
        var m = today.getMinutes();
        if (m < 10) {
            m = "0" + m
        }
        var s = today.getSeconds();
        if (s < 10) {
            s = "0" + s
        }
        var ms = today.getMilliseconds();
        if (ms < 10) {
            ms = "0" + ms
        }

        $('.sHeure').html(h + ":" + m + ":" + s + ":" + ms);
        delete today;

    }, 10);
}