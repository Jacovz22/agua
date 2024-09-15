function recorrerObjeto(obj) {
  // Validar si el parámetro es un objeto
  if (typeof obj !== "object" || obj === null) {
    return "";
  }

  let result = "";
  const keys = Object.keys(obj);

  // Manejo de un solo elemento
  if (keys.length === 1) {
    const value = obj[keys[0]];
    if (typeof value === "object" && value !== null) {
      return recorrerObjeto(value);
    } else {
      return `<p style="text-align: justify;">${value}</p>`;
    }
  }

  // Recorrido del objeto
  Object.entries(obj).forEach(([key, value]) => {
    if (Array.isArray(value)) {
      result += `<span style="color: black;">${key}</span>: [${value
        .map((item) =>
          typeof item === "object"
            ? "<br>" + recorrerObjeto(item) + "<br>"
            : item
        )
        .join(", ")}]<br>`;
    } else if (typeof value === "object" && value !== null) {
      result += `<span style="color: black;">${key}</span>:<br>${recorrerObjeto(
        value
      )}<br>`;
    } else {
      result += `<span style="color: black;">${key}</span>: ${value}<br>`;
    }
  });

  return `<p style="text-align: justify;">${result}</p>`;
}

let spinner = () => {
  $.blockUI({
    message: '<div class="spinner"></div>',
    css: {
      border: "none",
      backgroundColor: "transparent",
      position: "fixed",
      top: "50%",
      left: "50%",
      transform: "translate(-50%, -50%)" /* Centrado */,
      textAlign: "center",
      width: "100%" /* Asegura que ocupe todo el ancho */,
      zIndex: 1060,
    },
    overlayCSS: {
      backgroundColor: "#000",
      opacity: 0.6,
      cursor: "wait",
      zIndex: 1060,
    },
  });
};

let delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};

let convertirMayusculas = (input) => {
  input.value = input.value.toUpperCase();
};

let limpiarInputs = (clase) => {
  // Selecciona todos los elementos con la clase especificada
  var elements = document.querySelectorAll("." + clase);

  // Recorre cada elemento y limpia o restablece su valor
  elements.forEach(function (element) {
    switch (element.type) {
      case "text":
      case "email":
      case "textarea":
      case "number":
      case "password":
        element.value = ""; // Limpiar el valor del input o textarea
        break;
      case "select-one":
      case "select-multiple":
        element.selectedIndex = 0; // Restablecer el select al primer valor
        break;
      case "radio":
      case "checkbox":
        element.checked = false; // Deseleccionar radios y checkboxes
        break;
      default:
        element.value = ""; // Limpiar cualquier otro tipo de input
    }
  });
};
