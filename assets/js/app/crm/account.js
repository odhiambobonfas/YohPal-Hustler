function toggleAccount(checkbox) {
  $.ajax({
    url: "/crm/switch-acct",
    method: "POST",
    success: function (response) {
      const d = JSON.parse(response);
      route(d.route);
    },
    error: function (xhr) {
      console.error("Failed to update status:", xhr.responseText);
      checkbox.checked = !checkbox.checked;
    },
  });
}
