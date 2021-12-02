function confirmDelete() {
  window.event.preventDefault()
  let reponse = confirm("Êtes-vous sûr de vouloir supprimer " + window.event.target.dataset.ctrl + " : " + window.event.target.dataset.text + " ?")
  if (reponse) {
    window.location.href = window.event.target.getAttribute('href')
  }
}

//Error & Success message bar (under the NavBar)
document.addEventListener("DOMContentLoaded", function(){
var alertMsg = document.querySelector(".alertMsg")
    setInterval(function(){
        alertMsg.style.opacity = '0';
    }, 5000);
});
