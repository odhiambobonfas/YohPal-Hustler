document.addEventListener("DOMContentLoaded", function () {
  const cookieBanner = document.getElementById("cookie-banner");
  const agreeButton = document.getElementById("agree-cookie");
  const noThanksButton = document.getElementById("no-thanks-cookie");

  // Check if the cookie has been set
  if (localStorage.getItem("cookieConsent") === "granted") {
    cookieBanner.style.display = "none"; // Hide if already agreed
  } else if (localStorage.getItem("cookieConsent") === "denied") {
    cookieBanner.style.display = "none"; // Hide if already denied (optional, you might want to show it again or have different logic)
  } else {
    cookieBanner.style.display = "block"; // Show if no consent yet
  }

  agreeButton.addEventListener("click", function () {
    localStorage.setItem("cookieConsent", "granted");
    cookieBanner.style.display = "none";
    console.log("Cookie consent: Granted");
  });

  noThanksButton.addEventListener("click", function () {
    localStorage.setItem("cookieConsent", "denied");
    cookieBanner.style.display = "none";
    console.log("Cookie consent: Denied");
    // You might implement different behavior here, e.g., limit tracking
  });
});
