var tblReuniones;
$(document).ready(() => {
  $("#formReuniones").on("submit", function (e) {
    saveReuniones(e);
  });
  $("#formChecklist").on("submit", function (e) {
    saveCheckList(e);
  });
  listReuniones();
});

let saveCheckList = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formChecklist")[0]);
    var idR = $("#idR").val();
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
          url: "../Archivos/sesiones/operaciones.php?op=saveCheckList",
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
              dataListCheckT(idR);
              limpiarInputs("limpiarCheckListLabel");
              $("#listTitulares").selectpicker("refresh");
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

let saveReuniones = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formReuniones")[0]);
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
          url: "../Archivos/sesiones/operaciones.php?op=saveReuniones",
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
              limpiarInputs("limpiarFormR");
              tblReuniones.ajax.reload();
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

let listReuniones = () => {
  tblReuniones = $("#tblReuniones")
    .dataTable({
      language: {
        search: "BUSCAR",
        info: "_START_ A _END_ DE _TOTAL_ ELEMENTOS",
      },
      dom: "Bfrtip",
      buttons: ["copy", "excel", "pdf"],
      ajax: {
        url: "../Archivos/sesiones/operaciones.php?op=tblReuniones",
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

let listTitulares = () => {
  $.post(
    "../Archivos/sesiones/operaciones.php?op=listTitulares",
    (result) => {
      console.log(result);
      $("#listTitulares").html(result.options);
      $("#listTitulares").selectpicker("refresh");
    },
    "JSON"
  );
};

let dataListCheckT = (id) => {
  $.post(
    "../Archivos/sesiones/operaciones.php?op=dataListCheckT",
    { id },
    (result) => {
      if (result.typeMessage.code == 200) {
        $("#listCheckT").html(result.options);
      } else {
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });
      }
    },
    "JSON"
  );
};

let pasarIdR = async (id) => {
  $("#modalCheckList").modal("show");
  $("#idR").val(id);
  dataListCheckT(id);
};

let dataReuniones = (idReunion) => {
  $.post(
    "../Archivos/sesiones/operaciones.php?op=dataReuniones",
    { idReunion },
    (result) => {
      console.log(result);
      if (result.typeMessage.code == 200) {
        $("#idReunion").val(idReunion);
        $("#titulo").val(result.data.Titulo);
        $("#Fecha").val(result.data.Fecha);
        $("#estatusR").val(result.data.Estatus);
      } else {
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });
      }
    },
    "JSON"
  );
};

let deleteAsistencia = (id, idReunion) => {
  try {
    Swal.fire({
      title: "¿Estás seguro(a) de eliminar la asistencia?",
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
        $.post(
          "../Archivos/sesiones/operaciones.php?op=deleteAsistencia",
          { id },
          (result) => {
            console.log(result);
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });
            dataListCheckT(idReunion);
            $.unblockUI();
          },
          "JSON"
        );
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

let solicitarPagoF = (id) => {
  try {
    Swal.fire({
      title: "¿Estás seguro(a) de solicitar pago?",
      text: "Esta acción solicitará el pago de los titulares del agua que no asistieron a la faena",
      icon: "question",
      input: "number",
      inputAttributes: {
        step: "0.01", // Permite hasta 2 decimales
        min: "0.01", // Valor mínimo
        max: "100000", // Puedes ajustar el valor máximo
        required: "true", // Campo obligatorio
      },
      inputPlaceholder: "Ingrese el monto",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
      preConfirm: (monto) => {
        // Validar que el valor sea obligatorio y tenga máximo 2 decimales
        if (!monto || isNaN(monto) || monto <= 0) {
          Swal.showValidationMessage("Por favor, ingrese un monto válido");
        }
        return monto;
      },
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        const montoCobro = Opcion.value; // Obtiene el valor ingresado

        // Envía el monto por POST
        spinner();
        await delay(1000);
        $.ajax({
          url: "../Archivos/sesiones/operaciones.php?op=solicitarPF",
          method: "POST",
          data: { id: id, montoCobro: montoCobro }, // Envío del monto
          dataType: "json",
          success: (response) => {
            console.log(response);
            $.unblockUI();
            Swal.fire({
              position: "center",
              icon: response.typeMessage.type,
              title: response.typeMessage.title,
              html: recorrerObjeto(response.description),
              showConfirmButton: true,
            });
          },
          error: (error) => {
            $.unblockUI();
            Swal.fire({
              position: "center",
              icon: "error",
              title: "¡Error al solicitar el pago!",
              showConfirmButton: false,
              timer: 1500,
            });
            console.error("Error en la solicitud:", error.responseText);
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
