function populateSelect(
  selectId,
  data,
  defaultOptionText = "--",
  defaultOptionValue = ""
) {
  // Get the select element by ID
  const selectElement = document.getElementById(selectId);

  // Check if the select element exists
  if (!selectElement) {
    window.alert(`The select element with ID '${selectId}' was not found.`);
    return;
  }

  // Clear any existing options in the select element
  selectElement.innerHTML = "";

  // Optionally, add a default option at the beginning of the select element
  const defaultOption = document.createElement("option");
  // Set the value of the default option
  defaultOption.value = defaultOptionValue;
  // Set the text content of the default option
  defaultOption.textContent = defaultOptionText;
  // Set the default option as selected
  defaultOption.selected = true;
  // Insert the default option at the beginning of the select element
  selectElement.insertBefore(defaultOption, selectElement.firstChild);

  // Iterate through each item in the data and create an option element for it
  for (const [key, value] of Object.entries(data)) {
    const option = document.createElement("option");
    // Set the value of the option element to the key
    option.value = key;
    // Set the text content of the option element to the value
    option.textContent = value;
    // Append the option element to the select element
    selectElement.appendChild(option);
  }
}

function updatePagination(totalPages, currentPage, loaderFunc) {
  const paginationContainer = document.getElementById("pagination");
  if (!paginationContainer) {
    window.alert(
      "Pagination container not found. Please make sure the div with id 'pagination' exists in your HTML."
    );
    return;
  }

  paginationContainer.innerHTML = "";

  for (let i = 1; i <= totalPages; i++) {
    const pageButton = document.createElement("button");
    pageButton.className = "btn btn-success mx-1";
    pageButton.innerText = i;
    if (i === currentPage) {
      pageButton.disabled = true;
    }
    pageButton.addEventListener("click", () => loaderFunc(i));
    paginationContainer.appendChild(pageButton);
  }
}
