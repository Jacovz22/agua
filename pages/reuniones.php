<?php
session_start();
if (isset($_SESSION['sesion'])) {
    include "../global/Header.php";
?>
    <title>Reuniones</title>
    <?php
    include "../global/menu.php";
    ?>
    <style>
        #modalCheckList .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
    <div class="col-12 justify-content-left d-flex row">
        <div class="col-12 justify-content-left d-flex row">
            <!-- Primer Card -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Reuniones</h6>
                    </div>
                    <div class="card-body">
                        <form action="" class="col-12 justify-content-left d-flex row mt-4" id="formReuniones" name="formReuniones">
                            <div class="col-12 col-lg-3" hidden>
                                <label for="idReunion">Id</label>
                                <input type="text" class="form-control form-control-sm limpiarFormR" id="idReunion" name="idReunion" readonly>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="titulo">Titulo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormR" id="titulo" name="titulo" required oninput="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="Fecha">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm limpiarFormR" id="Fecha" name="Fecha" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="estatusR">Estatus <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm limpiarFormR" name="estatusR" id="estatusR" required>
                                    <option value="Programada">Programada</option>
                                    <option value="En Curso">En Curso</option>
                                    <option value="Concluida">Concluida</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                            <div class="col-12 justify-content-center d-flex mt-3">
                                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar</button>
                                <button type="reset" class="btn btn-outline-secondary btn-sm" id="">Limpiar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Segundo Card -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista de asistencias</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-12 justify-content-left d-flex row mt-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="tblReuniones" width="100%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Fecha</th>
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
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalCheckList" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalCheckListLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <form action="" id="formChecklist" name="formChecklist">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCheckListLabel">Pase de lista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row">
                            <div class="col-12 col-lg-7" hidden>
                                <label for="idR">Id</label>
                                <input type="text" class="form-control form-control-sm" id="idR" name="idR" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <label for="listTitulares">Titulares <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm limpiarCheckListLabel selectpicker"
                                    data-live-search="true"
                                    data-size="5"
                                    name="listTitulares"
                                    id="listTitulares"
                                    title="------------------"
                                    required>
                                </select>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <label for="obsPase">Observaciones</label>
                                <textarea name="obsPase" id="obsPase" class="form-control limpiarCheckListLabel"></textarea>
                            </div>

                            <div class="col-12 justify-content-center d-flex mt-3">
                                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar</button>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <ul class="list-group list-group-flush" id="listCheckT"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include "../global/Fooder.php"; ?>
    <script src="../js/reuniones.js"></script>
    </body>

    </html>

<?php
} else {
    header("location:../index.php");
}
?>