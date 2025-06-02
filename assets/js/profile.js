document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab");
  const tabContents = document.querySelectorAll(".tab-content");
  const statusButton = document.querySelector("#statusButton");
  const viewClientProfileLinks = document.querySelectorAll(
    ".view-client-profile"
  );

  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      tabs.forEach((t) => t.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));

      this.classList.add("active");
      document
        .getElementById(this.getAttribute("data-tab"))
        .classList.add("active");
    });
  });

  document
    .querySelector(".transfer-btn")
    .addEventListener("click", function () {
      alert("Transfer functionality - Available Funds: KSH 105,000");
    });

  if (statusButton) {
    statusButton.addEventListener("click", function () {
      if (this.textContent === "AVAILABLE NOW") {
        this.textContent = "ENGAGED";
        this.classList.add("engaged");
      } else {
        this.textContent = "AVAILABLE NOW";
        this.classList.remove("engaged");
      }
    });
  }

  viewClientProfileLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const clientId = this.getAttribute("data-client-id");
      window.location.href =
        "./index.php?url=public_prof&client_id=" + clientId;
    });
  });
});
