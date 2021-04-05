<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'SUNRISE';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('jquery.dataTables.min.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('datepicker3.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>

    <?= $this->Html->css('fonts.css') ?>
    <?= $this->Html->css('select2.min.css') ?>

    <?= $this->Html->script("jquery-1.11.1.min.js") ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nouveau Paiement Client</h4>
      </div>
      <?= $this->Form->create('', array('url' => "/cpayments/add")) ?>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-12"><?= $this->Form->control('customer_id', ['style' => "height:45px", 'label' => "Client", 'options' => $custs, 'class' => 'form-control select2']); ?></div>
          </div>
          <hr>
          <div class="row">
              <div class="col-md-6"><?= $this->Form->control('amount', ['class' => 'form-control', 'label' => false, 'placeholder' => "Montant"]); ?></div>
              <div class="col-md-6"><?= $this->Form->control('rate_id', ['style' => "height:45px", 'label' => false, 'options' => $rts, 'class' => 'form-control']); ?></div>
          </div>
      </div>
      <div class="modal-footer">
      <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"margin-left:7px;float:right")) ?>
        <button class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
      <?= $this->Form->end() ?>
    </div>

  </div>
</div>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="#"><span>SUNRISE</span>AIRWAYS</a>
                
                <ul class="nav navbar-top-links navbar-right">

                    <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <span class="fa fa-user" style="font-size: 28px;margin-top: -5px;margin-left: 1px;"></span>
                    </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="<?= ROOT_DIREC ?>/users/view/<?= $user_connected['id'] ?>"><span class="fa fa-user">&nbsp;</span> Profil</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= ROOT_DIREC ?>/users/logout"><span class="fa fa-power-off">&nbsp;</span> Déconnexion</a>
                            </li>

                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                    <?= $this->Form->create("", array("url" => "/sales/set_dates")) ?>
                    <input value="<?= $filterfrom  ?>" type="date" name="from" style="margin-top: 15px;height: 30px;width: 187px;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;">
                    <input value="<?= $filterto  ?>" type="date" name="to" style="height: 30px;width: 187px;background: #f2f2f2;color: black;border-radius: 3px;margin-right: 5px;">
                    <button class="btn btn-success" style="padding: 5px 12px!important;
    margin-top: -3px!important;"><span class="glyphicon glyphicon-ok" ></span></button>
                    <?= $this->Form->end() ?>
                </li>
                </ul>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-usertitle" style="margin:auto;width:100%">
                <div class="profile-usertitle-name text-center" style="margin-top:12px"><?= $user_connected['first_name']." ".$user_connected['last_name'] ?></div>
                <div class="profile-usertitle-status text-center"><span class="indicator label-success"></span>En ligne</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <?= $this->Form->create('', array("url" => "/sales/search", 'id' => "formtosubmit")) ?>
            <div class="form-group">
                <input type="text" class="form-control" name = "sale_ident" id="formtochange" placeholder="Recherche Ticket..." style="font-size: 15px;">
            </div>
        <?= $this->Form->end() ?>
        <div class="divider"></div>
        <ul class="nav menu" style="margin-top:0px">
            <?php if($user_connected['role_id'] ==1 || $user_connected['role_id'] ==3 || $user_connected['role_id'] ==4) : ?>
            <li class="parent <?= ($this->request->getParam('controller') == 'Sales') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-4">
                <em class="fa fa-cc">&nbsp;</em> Rapports <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-4">
                    <li><a class="" href="<?= ROOT_DIREC ?>/sales">
                        <span class="fa fa-arrow-right">&nbsp;</span> Ventes détaillées
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/sales/monthly">
                        <span class="fa fa-arrow-right">&nbsp;</span> Ventes Journalières
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/customers/statements">
                        <span class="fa fa-arrow-right">&nbsp;</span> Etat de Compte
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/sales/closing">
                        <span class="fa fa-arrow-right">&nbsp;</span> Fermeture de caisse
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/customers/products">
                        <span class="fa fa-arrow-right">&nbsp;</span> Clients
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/sales/products">
                        <span class="fa fa-arrow-right">&nbsp;</span> Ventes par produits
                    </a></li>
                    <li><a class="" href="<?= ROOT_DIREC ?>/sales/colis">
                        <span class="fa fa-arrow-right">&nbsp;</span> Colis Attendus
                    </a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if($user_connected['role_id'] ==1) : ?>
            <li class="parent <?= ($this->request->getParam('controller') == 'Products' || $this->request->getParam('controller') == 'Categories') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-1">
                <em class="fa fa-shopping-cart">&nbsp;</em> Catalogue <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-1">
                    <li class="<?= ($this->request->getParam('controller') == 'Products') ? 'active' : '' ?>" ><a class="" href="<?= ROOT_DIREC ?>/products">
                        <span class="fa fa-arrow-right">&nbsp;</span> Produits
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Categories') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/categories">
                        <span class="fa fa-arrow-right">&nbsp;</span> Catégories
                    </a></li>
                    <li><a class=""  href="<?= ROOT_DIREC ?>/products/add">
                        <span class="fa fa-arrow-right">&nbsp;</span> Nouveau Produit
                    </a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if($user_connected['role_id'] ==1) : ?>
            <li class="parent <?= ($this->request->getParam('controller') == 'Users' || $this->request->getParam('controller') == 'Roles' || $this->request->getParam('controller') == 'Cards') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-2">
                <em class="fa fa-users">&nbsp;</em> Utilisateurs <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-2">
                    <li class="<?= ($this->request->getParam('controller') == 'Users') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/users">
                        <span class="fa fa-arrow-right">&nbsp;</span> Utilisateurs
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Roles') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/roles">
                        <span class="fa fa-arrow-right">&nbsp;</span> Rôles
                    </a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Cards') ? 'active' : '' ?>"><a class="" href="<?= ROOT_DIREC ?>/cards">
                        <span class="fa fa-arrow-right">&nbsp;</span> Cartes
                    </a></li>
                    <li><a class=""  href="<?= ROOT_DIREC ?>/users/add">
                        <span class="fa fa-arrow-right">&nbsp;</span> Nouvel Utilisateur
                    </a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if($user_connected['role_id'] ==1 || $user_connected['role_id'] ==3) : ?>
            <li class="parent <?= ($this->request->getParam('controller') == 'Customers' || $this->request->getParam('controller') == 'Invoices' || $this->request->getParam('controller') == 'Payments') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-5">
                <em class="fa fa-cc">&nbsp;</em> Clients <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-5">
                    <li class="<?= ($this->request->getParam('controller') == 'Customers') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/customers"><em class="fa fa-arrow-right">&nbsp;</em> Clients</a></li>

                    <li class="<?= ($this->request->getParam('controller') == 'Payments') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/payments">
                        <span class="fa fa-arrow-right">&nbsp;</span> Paiements
                    </a></li>

                    <li><a class=""  href="<?= ROOT_DIREC ?>/customers/add">
                        <span class="fa fa-arrow-right">&nbsp;</span> Nouveau Client
                    </a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if($user_connected['role_id'] ==1) : ?>
            <li class="<?= ($this->request->getParam('controller') == 'Trucks') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/trucks"><em class="fa fa-truck">&nbsp;</em> Paquets</a></li>
            


            <li class="parent <?= ($this->request->getParam('controller') == 'Pointofsales' || $this->request->getParam('controller') == 'Rates' || $this->request->getParam('controller') == 'Methods') ? 'active' : '' ?>"><a data-toggle="collapse" href="#sub-item-3">
                <em class="fa fa-cog">&nbsp;</em> Configuration <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-3">
                    <li class="<?= ($this->request->getParam('controller') == 'Pointofsales') ? 'active' : '' ?>"><a  href="<?= ROOT_DIREC ?>/pointofsales"><em class="fa fa-arrow-right">&nbsp;</em> POS</a></li>
                    <li class="<?= ($this->request->getParam('controller') == 'Rates') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/rates">
                        <span class="fa fa-arrow-right">&nbsp;</span> Taux du jour
                    </a></li>
                    <li  class="<?= ($this->request->getParam('controller') == 'Methods') ? 'active' : '' ?>"><a class=""  href="<?= ROOT_DIREC ?>/methods">
                        <span class="fa fa-arrow-right">&nbsp;</span> Paiements
                    </a></li>
                </ul>
            </li>
        <?php endif; ?>
        </ul>
    </div><!--/.sidebar-->
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        
            <?= $this->fetch('content') ?>

        <footer>

        </footer>

    </div>

    <?= $this->Html->script("jquery-1.11.1.min.js") ?>
    <?= $this->Html->script("datatable/jquery.datatable.min.js") ?>
    <?= $this->Html->script("datatable/dataTables.buttons.min.js") ?>
    <?= $this->Html->script("datatable/buttons.flash.min.js") ?>
    <?= $this->Html->script("datatable/jszip.min.js") ?>
    <?= $this->Html->script("datatable/pdfmake.min.js") ?>
    <?= $this->Html->script("datatable/vfs_fonts.js") ?>
    <?= $this->Html->script("datatable/buttons.html5.min.js") ?>
    <?= $this->Html->script("datatable/buttons.print.min.js") ?>
    <?= $this->Html->script("datatable/dataTables.fixedColumns.min.js") ?>
    <?= $this->Html->script("bootstrap.js") ?>
    <?= $this->Html->script("bootstrap-datepicker.js") ?>
    <?= $this->Html->script("custom.js") ?>
    <?= $this->Html->script("select2.min.js") ?>
    
    <style type="text/css">
        div.message.success{
            background: #dff0d8;
            padding: 13px;
            margin: 14px;
            text-align: center;
        }
        div.message.error{
            background: #f2dede;
            padding: 13px;
            margin: 14px;
            text-align: center;
        }
        /*.breadcrumb{
            margin-top:-20px!important;
        }*/
        .fa-plus{
            margin-top:10px!important;
        }

        .select2-container{
            width:100%!important;
        }
    </style>

    <script type="text/javascript">
        $(function(){
            $("#formtochange").change(function(){
                $("#formtosubmit").submit();
            })

            $('.select2').select2();
        })
    </script>
</body>
</html>
