var serverData;
var selfUrl;
//creo un ID progressivo
var nextID = 10006;


function leggiServer(url){
  selfUrl = url;
  //Chiamata GET Ajax
  $.get( url, function( msg ) {
    serverData = msg;
    displayEmployeeList();
  });
  console.log(serverData);
}

//Stampa lista Dipendenti
function displayEmployeeList(){
//creo il body della tabella
  var rows = '';
  $.each(serverData["_embedded"]["employees"], function(index, value){
    rows = rows + '<tr>';
    rows = rows + '<td>' + value.id + '</td>';
    rows = rows + '<td>' + value.first_name + '</td>';
    rows = rows + '<td>' + value.last_name + '</td>';
    rows = rows + '<td>' + value.gender + '</td>';
    rows = rows + '<td data-id="' + value.id + '">';
    rows = rows + '<button class="btn btn-warning btn-sm modifica-dipendente" onclick = "setModal(' + value.id + ')" data-bs-toggle="modal" data-bs-target="#modifica-dipendente"> Modifica </button>  ';
    rows = rows + '<button class="btn btn-danger btn-sm elimina-dipendente"> Elimina </button>';
    rows = rows + '</td>';
    rows = rows + '</tr>';
  });
    
  //attraverso il metodo html di jQuery sostituisco il body creato (rows) all'attributo tbody della tabella
    $("#tbody").html(rows);
  }

function setModal(id) {
  $("#nomeMod").prop("placeholder", $("#nome-" + id).text());
  $("#cognomeMod").prop("placeholder", $("#cognome-" + id).text());
  $("#genereMod").val($("#genere-" + id).text());
}

$(document).ready(function (){

  leggiServer("http://localhost:8090/index.php");

    //Aggiungo un Dipendente
    $('#aggiungi').on('click', function(element){
        element.preventDefault(); //prevenire il comportamento di default e poterlo gestire

        var nome = $("#nome").val();
        var cognome = $("#cognome").val();
        var genere = $("#genere").val();
        var payload = { first_name: nome, last_name: cognome, gender: genere };

        if(nome != "" && cognome != ""){
          //Chiamata POST Ajax
          
          $.ajax({
            method: "POST",
            url: "http://localhost:8090/index.php",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(payload)
          })
          .done(function( msg ) {
            alert( 'Item creato con Successo!', 'Success Alert', {timeout: 5000});
          });
          

          nextID++;
          $("#crea-dipendente").modal('hide');
        }
        else{
          alert("Tutti i campi devono essere riempiti! Riprova...");
        }
    });

    //Elimina Dipendente
    $("body").on("click", ".elimina-dipendente", function(){
      var id = $(this).parent("td").data("id");

      $.ajax({
        type: "DELETE",
        url: "http://localhost:8090/index.php?id=" + id,
        success: function (data) {
          leggiServer(selfUrl);
        }
      });
    });

    //Modifica Dipendente
    $("body").on("click", "#modify", function(){
      var id = $(this).parent("td").data("id");
      //setModal(id);

      var genere = $(this).parent("td").prev("td").text();
      var cognome = $(this).parent("td").prev("td").prev("td").text();
      var nome = $(this).parent("td").prev("td").prev("td").prev("td").text();

      $("#nomeMod").val(nome);
      $("#cognomeMod").val(cognome);
      $("#genereMod").val(genere);
      
      $("#modify").on("click", function(e){
        e.preventDefault();

        var name = $("#nomeMod").val();
        var surname = $("#cognomeMod").val();
        var sesso = $("#genereMod").val();

        var payload = { first_name: name, lastName: surname, gender: sesso };
        //METTERE UNA NUOVA CHIAMATA GET PER AGGIORNARE
        
        $.ajax({
          type: 'PUT',
          url: "http://localhost:8090/index.php?id=" + id,
          dataType: "json",
          contentType: "application/json",
          data: JSON.stringify(payload),

          success: function(data) {
            leggiServer(selfUrl);
          }

        });

        //CHIAMATA GET PER AGGIORNARE I DATI NEL FRONTEND
        $.ajax({
          method: "GET",
          url: "http://localhost:8090/index.php",
          dataType: "json",
          contentType: "application/json"
        })

        $("#modifica-dipendente").modal("hide");

      });
    });


});

function linkNext(){
  leggiServer(serverData[ "_links"]["next"]["href"]);
};

function linkFirst(){
  leggiServer(serverData[ "_links"]["first"]["href"]);
};

function linkLast(){
  leggiServer(serverData[ "_links"]["last"]["href"]);
};

function linkPrev(){
  leggiServer(serverData[ "_links"]["prev"]["href"]);
};

function linkSelf(){
  leggiServer(serverData[ "_links"]["self"]["href"]);
};


