let tblTransacciones;
$(document).ready(() => {
  $("#formTransacciones").on("submit", function (e) {
    saveTransacciones(e);
  });
  listTransacciones();
});

let saveTransacciones = (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formTransacciones")[0]);
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
          url: "../Archivos/tranzacciones/operaciones.php?op=saveTransacciones",
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
              tblTransacciones.ajax.reload();
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

let listTransacciones = () => {
  tblTransacciones = $("#tblTransacciones")
    .dataTable({
      language: {
        search: "BUSCAR",
        info: "_START_ A _END_ DE _TOTAL_ ELEMENTOS",
      },
      dom: "Bfrtip",
      buttons: ["copy", "excel", "pdf"],
      ajax: {
        url: "../Archivos/tranzacciones/operaciones.php?op=listTransacciones",
        type: "post",
        dataType: "json",
        error: (e) => {
          console.error("Error función listar() \n" + e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 20,
      order: [[2, "asc"]],
    })
    .DataTable();
};

let dataTransaccion = (idTransaccion) => {
  try {
    spinner();
    $.post(
      "../Archivos/tranzacciones/operaciones.php?op=dataTransaccion",
      { idTransaccion },
      async (result) => {
        console.log(result);
        await delay(1000);
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: true,
        });

        $("#idTransaccion").val(idTransaccion);
        $("#titulo").val(result.data.Titulo);
        $("#fecha").val(result.data.Fecha);
        $("#tipoT").val(result.data.Tipo);
        $("#montoT").val(result.data.Monto);
        $("#descipcionT").val(result.data.Descripcion);
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

let updateStatusA = (idTransaccion) => {
  try {
    spinner();
    Swal.fire({
      title: "Confirmar activación de transacción",
      text: "¿Estás seguro de activar la transaccion seleccionada?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0a6541",
      cancelButtonColor: "#d33",
      confirmButtonText: "Continuar",
    }).then(async (Opcion) => {
      if (Opcion.isConfirmed) {
        await delay(500);
        $.post(
          "../Archivos/tranzacciones/operaciones.php?op=updateStatusA",
          { idTransaccion },
          (result) => {
            Swal.fire({
              position: "center",
              icon: result.typeMessage.type,
              title: result.typeMessage.title,
              html: recorrerObjeto(result.description),
              showConfirmButton: true,
            });
            $.unblockUI();
            tblTransacciones.ajax.reload();
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

let updateStatusB = (idTransaccion) => {
    try {
      spinner();
      Swal.fire({
        title: "Confirmar cancelación de transacción",
        text: "¿Estás seguro de cancelar la cancelar la transaccion seleccionada?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0a6541",
        cancelButtonColor: "#d33",
        confirmButtonText: "Continuar",
      }).then(async (Opcion) => {
        if (Opcion.isConfirmed) {
          await delay(500);
          $.post(
            "../Archivos/tranzacciones/operaciones.php?op=updateStatusB",
            { idTransaccion },
            (result) => {
              Swal.fire({
                position: "center",
                icon: result.typeMessage.type,
                title: result.typeMessage.title,
                html: recorrerObjeto(result.description),
                showConfirmButton: true,
              });
              $.unblockUI();
              tblTransacciones.ajax.reload();
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
