$(document).ready(() => {
  $("#formLogin").on("submit", function (e) {
    login(e);
  });
});

let login = async (e) => {
  e.preventDefault();
  try {
    let data = new FormData($("#formLogin")[0]);
    spinner();
    await delay(1000);
    $.ajax({
      type: "POST",
      url: "../Archivos/login/operaciones.php?op=login",
      data: data,
      contentType: false,
      processData: false,
      dataType: "json",
      success: async function (result) {
        console.log(result);
        Swal.fire({
          position: "center",
          icon: result.typeMessage.type,
          title: result.typeMessage.title,
          html: recorrerObjeto(result.description),
          showConfirmButton: false,
          timer: 3000,
        });
        if (result.typeMessage.code == 200) {
          await delay(1000);
          window.location.href = "../pages/home.php";
        }
        $.unblockUI();
      },
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
