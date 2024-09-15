var tblTitulares;
var tblPagos;
var tblPagosPar;
$(document).ready(() => {
  $("#formTitulares").on("submit", function (e) {
    saveTitular(e);
  });

  $("#formAddress").on("submit", function (e) {
    saveAdrress(e);
  });

  $("#formPagos").on("submit", function (e) {
    guardarPago(e);
  });
  $("#formPagosPar").on("submit", function (e) {
    guardarPagoPar(e);
  });

  twoSearchAddress();
  listTitulares();
});

let saveTitular = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formTitulares")[0]);
    Swal.fire({
      title: "¿Estás seguro(a) de guardar?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        spinner();
        await delay(1000);
        $.ajax({
          type: "POST",
          url: "../Archivos/titulares/operaciones.php?op=saveTitular",
          data: data,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (result) {
            $.unblockUI();
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });

            if (result.typeMessage.code == 200) {
              limpiarInputs("limpiarFormT");
              tblTitulares.ajax.reload();
            }
          },
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "info",
          title: "¡Operación cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  } catch (error) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};
let saveAdrress = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formAddress")[0]);
    var countD = $("#countD").val();
    Swal.fire({
      title: "¿Estás seguro(a) de guardar?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        spinner();
        await delay(1000);
        $.ajax({
          type: "POST",
          url: "../Archivos/titulares/operaciones.php?op=saveAdrress",
          data: data,
          contentType: false,
          processData: false,
          dataType: "json",
          success: async function (result) {
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });
            if (result.typeMessage.code == 200) {
              $("#idDireccionN").val(result.typeMessage.idSave);
              $("#modalDirecciones").modal("hide");
              var options = await searchAddress();
              if (countD == 1) {
                $("#idDireccionTitular").html(options.description.options);
                await delay(500);
                $("#idDireccionTitular").prop("disabled", true);
                $("#idDireccionTitular").val(result.typeMessage.idSave);
              } else {
                $("#idDireccionT").html(options.description.options);
                await delay(500);
                $("#idDireccionT").prop("disabled", true);
                $("#idDireccionT").val(result.typeMessage.idSave);
              }
            }

            $.unblockUI();
          },
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "info",
          title: "¡Operación cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  } catch (error) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};
let twoSearchAddress = async () => {
  var options = await searchAddress();
  $("#idDireccionTitular").html(options.description.options);
  $("#idDireccionT").html(options.description.options);
};
let searchAddress = async () => {
  try {
    let result = await $.post(
      "../Archivos/titulares/operaciones.php?op=searchAddress",
      null,
      null,
      "json"
    );
    return result;
  } catch (error) {
    throw error;
  }
};
let pasarId = () => {
  $("#countD").val("1");
  limpiarInputs("limpiarFormD");
  var idDireccion = $("#idDireccionTitular").val();
  dataModal(idDireccion);
};
let pasarIdT = () => {
  $("#countD").val("2");
  limpiarInputs("limpiarFormD");
  var idDireccion = $("#idDireccionT").val();
  dataModal(idDireccion);
};
let dataModal = async (idDireccion) => {
  try {
    if (idDireccion == "" || idDireccion == null) {
      $("#modalDirecciones").modal("show");
    } else {
      var result = await searchAddressId(idDireccion);
      if (result.typeMessage.code == 200) {
        $("#modalDirecciones").modal("show");
        $("#idDireccionN").val(idDireccion);
        $("#cp").val(result.description.resutl.CodigoPostal);
        $("#colonia").val(result.description.resutl.Colonia);
        $("#calle").val(result.description.resutl.Calle);
        $("#nInterior").val(result.description.resutl.NumeroInterior);
        $("#nExterior").val(result.description.resutl.NumeroExterior);
      } else {
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });
      }
    }
  } catch (error) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Error",
      text: "Hubo un problema al procesar la solicitud.",
      showConfirmButton: true,
    });
  }
};
let searchAddressId = async (idDireccionN) => {
  let result = await $.post(
    "../Archivos/titulares/operaciones.php?op=searchAddressId",
    { idDireccionN },
    null,
    "JSON"
  );
  return result;
};

let updateStatusA = (TitularID) => {
  try {
    spinner();
    Swal.fire({
      title: "Confirmar reactivación del titular de agua potable",
      text: "¿Estás seguro de que deseas reactivar al titular seleccionado?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        await delay(500);
        $.post(
          "../Archivos/titulares/operaciones.php?op=updateStatusA",
          { TitularID },
          (result) => {
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });
            $.unblockUI();
            tblTitulares.ajax.reload();
          },
          "JSON"
        );
      } else {
        $.unblockUI();
        Swal.fire({
          position: "center",
          icon: "info",
          title: "¡Operación cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  } catch (error) {
    $.unblockUI();
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrió un error inesperado",
      text: error.message || "Error desconocido",
    });
  }
};

let updateStatusI = (TitularID) => {
  try {
    spinner();
    Swal.fire({
      title: "Confirmar baja del titular de agua potable",
      text: "¿Estás seguro de que deseas dar de baja al titular seleccionado?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        await delay(500);
        $.post(
          "../Archivos/titulares/operaciones.php?op=updateStatusI",
          { TitularID },
          (result) => {
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });
            $.unblockUI();
            tblTitulares.ajax.reload();
          },
          "JSON"
        );
      } else {
        $.unblockUI();
        Swal.fire({
          position: "center",
          icon: "info",
          title: "¡Operación cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  } catch (error) {
    $.unblockUI();
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrió un error inesperado",
      text: error.message || "Error desconocido",
    });
  }
};

let listTitulares = () => {
  tblTitulares = $("#tblTitulares")
    .dataTable({
      language: {
        search: "BUSCAR",
        info: "_START_ A _END_ DE _TOTAL_ ELEMENTOS",
      },
      dom: "Bfrtip",
      buttons: ["copy", "excel", "pdf"],
      ajax: {
        url: "../Archivos/titulares/operaciones.php?op=listTitulares",
        type: "post",
        dataType: "json",
        error: (e) => {
          console.error("Error función listar() \n" + e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 20,
      order: [[0, "asc"]],
    })
    .DataTable();
};

let dataTitular = (TitularID) => {
  try {
    spinner();
    $.post(
      "../Archivos/titulares/operaciones.php?op=dataTitular",
      { TitularID },
      async (result) => {
        await delay(1000);
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });
        $("#TitularID").val(TitularID);
        $("#nombre").val(result.data.NombreTitular);
        $("#apellidoP").val(result.data.ApellidoPaterno);
        $("#apellidoM").val(result.data.ApellidoMaterno);
        $("#tomaA").val(result.data.TieneTomaAgua);
        $("#correo").val(result.data.Email);
        $("#celular").val(result.data.Telefono);
        $("#idDireccionTitular").val(result.data.DireccionID);
        $("#idDireccionT").val(result.data.DireccionTomaID);
        $("#obs").val(result.data.Observaciones);
        $.unblockUI(result.data);
      },
      "JSON"
    );
  } catch (error) {
    $.unblockUI();
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};

let modalPagos = (TitularID) => {
  $("#modalPagos").modal("show");
  $("#idTitularP").val(TitularID);
  listPagos(TitularID);
};

let guardarPago = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formPagos")[0]);
    Swal.fire({
      title: "¿Estás seguro(a) de guardar?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        spinner();
        await delay(1000);
        $.ajax({
          type: "POST",
          url: "../Archivos/titulares/operaciones.php?op=guardarPago",
          data: data,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (result) {
            $.unblockUI();
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });

            if (result.typeMessage.code == 200) {
              tblPagos.ajax.reload();
              limpiarInputs("limpiarFormPago");
            }
          },
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "info",
          title: "¡Operación cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  } catch (error) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};

let listPagos = (TitularID) => {
  tblPagos = $("#tblPagos")
    .dataTable({
      language: {
        search: "BUSCAR",
        info: "_START_ A _END_ DE _TOTAL_ ELEMENTOS",
      },
      dom: "Bfrtip",
      buttons: ["copy", "excel", "pdf"],
      ajax: {
        url: "../Archivos/titulares/operaciones.php?op=listPagos",
        type: "post",
        dataType: "json",
        data: { TitularID },
        error: (e) => {
          console.error("Error función listar() \n" + e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 20,
      order: [[0, "asc"]],
    })
    .DataTable();
};

let dataPagos = (idPago) => {
  try {
    spinner();
    $.post(
      "../Archivos/titulares/operaciones.php?op=dataPagos",
      { idPago },
      async (result) => {
        await delay(1000);
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });
        $("#idPago").val(idPago);
        $("#concepto").val(result.data.Concepto);
        $("#fechaP").val(result.data.Fecha);
        $("#montoP").val(result.data.Monto);
        $("#estatusP").val(result.data.Estatus);
        $.unblockUI(result.data);
      },
      "JSON"
    );
  } catch (error) {
    $.unblockUI();
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};

let mostrarPagosPar = (idPago) => {
  $("#modalPagosPar").modal("show");
  $("#idPagoP").val(idPago);
  listarPagosPar(idPago);
};

let guardarPagoPar = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formPagosPar")[0]);
    console.log(data);
    Swal.fire({
      title: "¿Estás seguro(a) de guardar?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        spinner();
        await delay(1000);
        $.ajax({
          type: "POST",
          url: "../Archivos/titulares/operaciones.php?op=guardarPagoPar",
          data: data,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (result) {
            $.unblockUI();
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });

            if (result.typeMessage.code == 200) {
              tblPagosPar.ajax.reload();
              limpiarInputs("limpiarFormPagoPar");
            }
          },
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "info",
          title: "¡Operación cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  } catch (error) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};

let listarPagosPar = (idPago) => {
  tblPagosPar = $("#tblPagosPar")
    .dataTable({
      language: {
        search: "BUSCAR",
        info: "_START_ A _END_ DE _TOTAL_ ELEMENTOS",
      },
      dom: "Bfrtip",
      buttons: ["copy", "excel", "pdf"],
      ajax: {
        url: "../Archivos/titulares/operaciones.php?op=listarPagosPar",
        type: "post",
        dataType: "json",
        data: { idPago },
        error: (e) => {
          console.error("Error función listar() \n" + e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 20,
      order: [[0, "asc"]],
    })
    .DataTable();
};

let dataPagosPar = (idPagoPar) => {
  try {
    spinner();
    $.post(
      "../Archivos/titulares/operaciones.php?op=dataPagosPar",
      { idPagoPar },
      async (result) => {
        await delay(1000);
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });

        $("#idPagoPar").val(idPagoPar);
        $("#conceptoPar").val(result.data.Concepto);
        $("#fechaPar").val(result.data.Fecha);
        $("#montoPar").val(result.data.Monto);
        $("#metodoPP").val(result.data.MetodoPago);
        $("#estatusPP").val(result.data.Estatus);

        $.unblockUI(result.data);
      },
      "JSON"
    );
  } catch (error) {
    $.unblockUI();
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Ocurrio un error inesperado",
      text: error,
    });
  }
};
