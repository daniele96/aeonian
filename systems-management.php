<?php
require_once("../../config.php"); 
require("../../classes/SystemsManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Utenti
$systemsManager = new SystemsManager();
$impianti = $systemsManager->getImpianti();


if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $var = $_POST['id'];
    switch($action) {
      case 'delete':
        $systemsManager->eliminaImpianto($var);
        break;
    }
}

?>

 <!-- START HEADER -->
 <?php require("./includes/header.php"); ?>
 
    <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START MAIN -->
  <div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

    <!-- START LEFT SIDEBAR NAV-->
        <?php require("./includes/sidebar.php"); ?>
    <!-- END LEFT SIDEBAR NAV-->


      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id="content">
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Gestione impianti</h5>
                <ol class="breadcrumbs">
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
          <div class="section">

            <!-- <p class="caption">Utenti </p> -->
            <a href="create-system.php" class="btn waves-effect queen-blue white-text admin-create-user"><i class="mdi-content-add right"></i>Crea impianto</a>
            <br><br>
            
            <div class="divider"></div>
            <br><br>

            <!-- START TABLE HERE -->
            <!--DataTables example-->
            <div id="table-datatables">

                <div class="col s12 m8 l12">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Indirizzo</th>
                            <th>Città</th>
                            <th>Responsabili</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                        <th>Nome</th>
                        <th>Indirizzo</th>
                        <th>Città</th>
                        <th>Responsabili</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        <?php foreach ($impianti as $impianto) :?>
                        <tr>
                        <?php 
                        $responsabili = $systemsManager->respFromImpianto($impianto['IDImpianto']);

                        ?>

                            <td><a href="system-details.php?id=<?php echo $impianto['IDImpianto']; ?>"><?php echo $impianto['Nome'] ?></a></td>
                            <td><?php echo $impianto['Indirizzo'] ?></td>
                            <td><?php echo $impianto['Citta'] ?></td>
                            
                            <td class="custom-cell">
                            <p>
                            <?php
                            $index=0;
                             foreach ($responsabili as $resp):
                              if($index==0)
                                 echo $resp['Nome']." ".$resp['Cognome'];

                              else  
                                 echo ", ".$resp['Nome']." ".$resp['Cognome'];

                             $index++;
                             endforeach;
                            ?>
                            </p>
                            <i onclick="elimina('<?php echo ROOT_URL.TEMPLATE_PATH.'installer-contents/systems-management.php';?>', '<?php echo $impianto['IDImpianto']; ?>')" class="custom-icon mdi-action-delete"></i>
                            </td>
                          
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div> 
            <br>
            <div class="divider"></div> 
            <!-- END TABLE HERE -->

          
        </div>
              <!--end container-->
      </section>
        <!-- END CONTENT -->

    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->
<br>
<br>
<br>


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START FOOTER -->
  <?php require("./includes/footer.php"); ?>
      
      