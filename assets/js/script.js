document.addEventListener("DOMContentLoaded", function() {
    var companyButtons = document.querySelectorAll(".company-button");
    companyButtons.forEach(function(button) {
      button.addEventListener("click", function() {
        var details = this.nextElementSibling;
        details.style.display = details.style.display === "none" ? "block" : "none";
      });
    });
  });