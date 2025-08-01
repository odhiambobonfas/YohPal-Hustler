function logout(btn) {
  toggleButtonContent(btn);
  $.ajax({
    type: "POST",
    url: "/auth/logout",
    dataType: "json",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
    success: function (response) {
      console.log(response);
      toggleButtonContent(btn, "", true);
      enableElement(btn);

      if (response && response.status && response.status == "success") {
        route(response.route);
        return;
      }

      if (response && response.status && response.status == "error") {
        toast(response.status, 5000, response.message || lang.undefined_error);
        return;
      }

      toast("error", 5000, lang.undefined_error);
    },
    error: (error) => {
      console.log(error.message || error);
      toggleButtonContent(btn, "", true);
      enableElement(btn);
      toast("error", 5000, lang.undefined_error);
    },
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const logoutBtns = document.querySelectorAll("#logout-nav");
  console.log(logoutBtns);
  if (!logoutBtns) return;
  logoutBtns.forEach((logoutBtn) => {
    logoutBtn.onclick = () => logout(logoutBtn);
  });
});
