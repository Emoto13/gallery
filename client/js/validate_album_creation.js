document
  .getElementById("album-creation-form")
  .addEventListener("submit", (event) => {
    // don't submit the form
    event.preventDefault();

    // Submit only if no errors were found
    if (isFormValid()) {
      document.getElementById("album-creation-form").submit();
    }
  });

function isFormValid() {
  if (document.getElementsByName("album-name")[0].value == "") {
    alert("Enter album name");
    document.getElementsByName("album-name")[0].focus();
    return false;
  }
  return true;
}
