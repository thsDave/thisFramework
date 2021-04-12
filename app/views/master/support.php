<?php require_once APP . "/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Soporte técnico</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?req=home">Inicio</a></li>
              <li class="breadcrumb-item active">Soporte</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Escribe tus consultas aquí.</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="form-group">
                  <label for="subject">Asunto</label>
                  <input type="text" class="form-control" id="subject" placeholder="Asunto" required>
                </div>
                <div class="form-group">
                  <label for="mssg">Comentarios</label>
                  <textarea class="form-control" id="mssg" rows="3" placeholder="Escribe aqui tus comentarios." required></textarea>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" id="sendreq" class="btn btn-dark">Enviar</button>
              </div>
            </div>
            <!-- /.card -->

          </div>

          <div class="col-md-8">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Historial de mensajes</h3>
            </div>
            <div class="direct-chat-messages" style="height: 320px !important;">
            <?= $objHome->historysupportreq($_SESSION['log']['id']); ?>
            </div>
          </div>
          <!-- /.card -->
        </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- SweetAlert2 -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/support.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
