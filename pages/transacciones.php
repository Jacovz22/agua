<?php
session_start();
if (isset($_SESSION['sesion'])) {
    include "../global/Header.php";
?>
    <title>Transacciones</title>
    <?php
    include "../global/menu.php";
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transacciones</h6>
        </div>
        <div class="card-body">
            <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row" id="formTransacciones">
                <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                    <label for="idTransaccion">Id</label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="idTransaccion" name="idTransaccion" readonly>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="titulo">Titulo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="titulo" name="titulo" required oninput="this.value = this.value.toUpperCase();">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="fecha">Fecha <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm limpiarFormT" id="fecha" name="fecha" required oninput="this.value = this.value.toUpperCase();">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="tipoT">Tipo <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm limpiarFormT" name="tipoT" id="tipoT" required>
                        <option value="Ingreso">Ingreso</option>
                        <option value="Egreso">Egreso</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="montoT">Monto <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-sm limpiarFormT" id="montoT" name="montoT" step="0.01" min="1" required>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label for="descipcionT">Descipcion</label>
                    <textarea name="descipcionT" id="descipcionT" class="form-control limpiarFormT" oninput="this.value = this.value.toUpperCase();"></textarea>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                    <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar </button>
                    <button type="reset" class="btn btn-outline-secondary btn-sm" id="Btn_Limpiar_C">Limpiar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-end d-flex mt-3">
                <a href="../Archivos/tranzacciones/reporteGatos.php" target="_blank" rel="noopener noreferrer" type="button" class="btn btn-outline-danger btn-sm mr-2" title="Impresion de resporte de gastos"><i class="fas fa-file-pdf"></i> </a>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="tblTransacciones" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Titulo</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Monto</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">--------</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include "../global/Fooder.php"; ?>
    <script src="../js/transacciones.js"></script>
    </body>

    </html>

<?php
} else {
    header("location:../index.php");
}
?>