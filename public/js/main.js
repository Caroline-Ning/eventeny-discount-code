window.onload = function () {
  const specific = document.querySelectorAll(".specific");
  const customerSearch = document.querySelector("#customer-search");
  const allCustomer = document.querySelector("#all-customer");

  specific.forEach((radio) => {
    radio.onclick = function () {
      customerSearch.classList.remove("hide");
    };
  });

  allCustomer.onclick = () => {
    customerSearch.classList.add("hide");
  };

  const endDateBox = document.querySelector("#end-date-checkbox");
  const endDateInput = document.querySelector("#end-date-input");

  endDateBox.onclick = function () {
    endDateInput.classList.toggle("hide");
  };
};
