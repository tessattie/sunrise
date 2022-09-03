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

    <?= $this->Html->css('datepicker3.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body style="background:#f3f3f3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-top:0px!important;padding-bottom:0px!important;background:white!important;text-align:center;border-bottom:1px solid #ddd">
      <a class="navbar-brand" href="https://sunriseairways.net" style="padding:0px!important"><?= $this->Html->image('logo_login.jpg', ['alt' => 'Sunrise Logo', 'style' => "width:100px"]); ?></a>
    </nav>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

    <footer class="bg-light text-center text-lg-start" style="position:fixed;bottom:0px;width:100%;margin-top:50px">
  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: #DDDBDB">
    © <a class="text-dark" href="https://sunriseairways.net/" style="text-decoration:none;font-weight:600">Sunrise Airways</a> - <?= date("Y") ?>
  </div>
  <!-- Copyright -->
</footer>

    <?= $this->Html->script("jquery-1.11.1.min.js") ?>
    <?= $this->Html->script("bootstrap.js") ?>
    <?= $this->Html->script("bootstrap-datepicker.js") ?>
    <?= $this->Html->script("custom.js") ?>
    
</body>
</html>
