document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab");
  const tabContents = document.querySelectorAll(".tab-content");
  const viewApplicantProfileLinks = document.querySelectorAll(
    ".view-applicant-profile"
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

  document.querySelectorAll(".contact-client").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      alert("Contacting Yohpal at contact@yohpal.com");
    });
  });

  viewApplicantProfileLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const applicantId = this.getAttribute("data-applicant-id");
      window.location.href = `./index.php?url=profile&applicant_id=${applicantId}`;
    });
  });
});
