document.getElementById("ratingForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Empêche la soumission du formulaire

  // Récupérer les données du formulaire
  var idRecette = document.getElementById("ratingForm").elements["idRecette"].value;
  var note = document.getElementById("note").value;
  var commentaire = document.getElementById("commentaire").value;
  var idUser = document.getElementById("ratingForm").elements["idUser"].value;

  // Effectuer une requête AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process_rating.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Réponse du serveur
      var response = xhr.responseText;
      // Faire quelque chose avec la réponse (par exemple, afficher un message)
    }
  };
  xhr.send("idRecette=" + idRecette + "&note=" + note + "&commentaire=" + commentaire  + "&idUser=" + idUser);
});