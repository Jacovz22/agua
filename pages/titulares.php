<?php
session_start();
if (isset($_SESSION['sesion'])) {
    include "../global/Header.php";
?>
    <title>titulares</title>
    <?php
    include "../global/menu.php";
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Usuarios de agua potable</h6>
        </div>
        <div class="card-body">
            <form action="" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row mt-4"
                id="formTitulares" name="formTitulares">
                <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                    <label for="TitularID">Id</label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="TitularID" name="TitularID" readonly>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="nombre" name="nombre" required oninput="this.value = this.value.toUpperCase();">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="apellidoP">Apellido Paterno <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="apellidoP" name="apellidoP" required oninput="this.value = this.value.toUpperCase();">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="apellidoM">Apellido Materno <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="apellidoM" name="apellidoM" required oninput="this.value = this.value.toUpperCase();">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="tomaA">¿Cuenta con toma de agua? <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm limpiarFormT" name="tomaA" id="tomaA" required>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control form-control-sm limpiarFormT" id="correo" name="correo" title="Debe ingresar un correo electrónico válido">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <label for="celular">Celular</label>
                    <input type="text" class="form-control form-control-sm limpiarFormT" id="celular" name="celular" pattern="\d{10}" title="Debe contener 10 dígitos">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <label for="idDireccionTitular">Dirección del titular</label>
                    <div class="input-group">
                        <select name="idDireccionTitular" id="idDireccionTitular" class="form-control limpiarFormT"></select>
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-primary" onclick="pasarId()"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <label for="idDireccionT">Dirección de toma</label>
                    <div class="input-group">
                        <select name="idDireccionT" id="idDireccionT" class="form-control limpiarFormT" title="Buscar direccion"></select>
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-success" onclick="pasarIdT()"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <label for="obs">Observaciones</label>
                    <textarea name="obs" id="obs" class="form-control" rows="3" oninput="this.value = this.value.toUpperCase();"></textarea>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                    <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar </button>
                    <button type="reset" class="btn btn-outline-secondary btn-sm" id="Btn_Limpiar_C">Limpiar</button>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-end d-flex mt-3">
                    <button type="button" class="btn btn-outline-success" disabled id="btnUserNew"><i class="fas fa-user-plus"></i></button>
                </div>

            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="tblTitulares" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Celular</th>
                                <th class="text-center">Estatus toma</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center" style="width: 10%;">--------</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDirecciones" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalDireccionesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="formAddress" name="formAddress">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDireccionesLabel">Direcciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                                <label for="countD">count</label>
                                <input type="text" class="form-control form-control-sm" id="countD" name="countD" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1" hidden>
                                <label for="idDireccionN">Id</label>
                                <input type="text" class="form-control form-control-sm limpiarFormD" id="idDireccionN" name="idDireccionN" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="cp">Codigo postal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormD" id="cp" name="cp" pattern="\d{5}" title="Debe contener 5 dígitos" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="colonia">Colonia<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormD" id="colonia" name="colonia" oninput="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="calle">calle <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormD" id="calle" name="calle" oninput="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="nInterior">Nº Interior <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormD" id="nInterior" name="nInterior" oninput="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="nExterior">Nº Exterior</label>
                                <input type="text" class="form-control form-control-sm limpiarFormD" id="nExterior" oninput="this.value = this.value.toUpperCase();" name="nExterior">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="formUserT" name="formUserT">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUserLabel">Usuarios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row">

                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="idUserT">Id Usuario</label>
                                <input type="text" class="form-control form-control-sm" id="idUserT" name="idUserT">
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="userName">Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="userName" name="userName" minlength="5" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="passUser">Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="passUser" name="passUser" class="form-control form-control-sm" minlength="8" required>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-success btn-sm"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <label for="rolUser">Rol <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="rolUser" id="rolUser" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Presidente">Presidente</option>
                                    <option value="Secretario">Secretario</option>
                                    <option value="Tesorero">Tesorero</option>
                                    <option value="Bocal">Bocal</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar </button>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pagos-->
    <div class="modal fade" id="modalPagos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPagosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="" id="formPagos" name="formPagos">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPagosLabel">Pagos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" hidden>
                                <label for="idTitularP">Id</label>
                                <input type="text" class="form-control form-control-sm" id="idTitularP" name="idTitularP" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" hidden>
                                <label for="idPago">Id pago</label>
                                <input type="text" class="form-control form-control-sm limpiarFormPago" id="idPago" name="idPago" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="concepto">Concepto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormPago" oninput="this.value = this.value.toUpperCase();" id="concepto" name="concepto" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="fechaP">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm limpiarFormPago" id="fechaP" name="fechaP" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="montoP">Monto <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm limpiarFormPago" id="montoP" name="montoP" step="0.01" min="1" required>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="estatusP">Estatus <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm limpiarFormPago" name="estatusP" id="estatusP" required>
                                    <option value="Activa">Activa</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Completada">Completada</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick='limpiarInputs("limpiarFormPago");'>Limpiar</button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm" id="tblPagos" width="100%" cellspacing="0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center">Concepto</th>
                                                <th class="text-center">Fecha</th>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pagos-->
    <div class="modal fade" id="modalPagosPar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPagosParLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="" id="formPagosPar" name="formPagosPar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPagosParLabel">Pagos parciales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" hidden>
                                <label for="idPagoP">Id</label>
                                <input type="text" class="form-control form-control-sm" id="idPagoP" name="idPagoP" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2" hidden>
                                <label for="idPagoPar">Id pagoP</label>
                                <input type="text" class="form-control form-control-sm limpiarFormPagoPar" id="idPagoPar" name="idPagoPar" readonly>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="conceptoPar">Concepto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm limpiarFormPagoPar" oninput="this.value = this.value.toUpperCase();" id="conceptoPar" name="conceptoPar" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="fechaPar">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm limpiarFormPagoPar" id="fechaPar" name="fechaPar" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="montoPar">Monto <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm limpiarFormPagoPar" id="montoPar" name="montoPar" step="0.01" min="1" required>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="metodoPP">Metodo pago <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm limpiarFormPagoPar" name="metodoPP" id="metodoPP" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                                <label for="estatusPP">Estatus <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm limpiarFormPagoPar" name="estatusPP" id="estatusPP" required>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Completado">Completado</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-center d-flex mt-3">
                                <button type="submit" class="btn btn-outline-success btn-sm mr-2">Guardar </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick='limpiarInputs("limpiarFormPagoPar");'>Limpiar</button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 justify-content-left d-flex row mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm" id="tblPagosPar" width="100%" cellspacing="0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center">Concepto</th>
                                                <th class="text-center">Fecha</th>
                                                <th class="text-center">Monto</th>
                                                <th class="text-center">Metodo pago</th>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../global/Fooder.php"; ?>
    <script src="../js/titulares.js"></script>
    </body>

    </html>
<?php
} else {
    header("location:../index.php");
}
?>