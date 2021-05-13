<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Fermeture</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Rapport de fermeture
            <?= $this->Form->create() ?>
                <div class="row" style="margin-left:-15px;margin-top:25px">
                    <div class="col-md-3">
                        <input type="date" name="date" value="<?= $date ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('station_id', array("class" => "form-control", 'options' => $stations, 'empty' => "-- Choisissez --", 'label' => false, "style" => 'height:45px')); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left;height:45px")) ?>
                    </div>
                    <div class="col-md-8"></div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container" style="padding-top:75px">
    <?php foreach($users as $user) : ?>
            <table class="table table-bordered datatable">
                <thead>
                <tr><th colspan="3"><?= $user->first_name." ".$user->last_name ?></th></tr>
                    <tr><th>Type</th><th class="text-center">HTG</th><th class="text-center">USD</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $cash_htg = 0;$cash_usd = 0; $cheque_usd = 0; $cheque_htg = 0; $carte_htg = 0; $carte_usd = 0; 
                    if(!empty($user->cash)){
                      foreach($user->cash as $cash){
                            if($cash['method_id'] == 1 && $cash['rate_id'] == 1){
                                $cash_htg = $cash_htg + $cash['amount'];
                            }

                            if($cash['method_id'] == 1 && $cash['rate_id'] == 2){
                                $cash_usd = $cash_usd + $cash['amount'];
                            }

                            if($cash['method_id'] == 2 && $cash['rate_id'] == 1){
                                $cheque_htg = $cheque_htg + $cash['amount'];
                            }

                            if($cash['method_id'] == 2 && $cash['rate_id'] == 2){
                                $cheque_usd = $cheque_usd + $cash['amount'];
                            }

                            if($cash['method_id'] == 3 && $cash['rate_id'] == 1){
                                $carte_htg = $carte_htg + $cash['amount'];
                            }

                            if($cash['method_id'] == 3 && $cash['rate_id'] == 2){
                                $carte_usd = $carte_usd + $cash['amount'];
                            }
                        }  
                    }
                    

                    ?>
                    <tr><th>Cash</th><td class="text-center"><?= number_format($cash_htg - $user->monnaie_htg['monnaie'], 2, ".", ",") ?> HTG</td> <td class="text-center"><?= number_format($cash_usd, 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Chèque </th> <td class="text-center"><?= number_format($cheque_htg, 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($cheque_usd, 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Carte </th> <td class="text-center"><?= number_format($carte_htg, 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($carte_usd, 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Crédit </th> <td class="text-center"><?= number_format($user->credit_htg['total'], 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($user->credit_usd['total'], 2, ".", ",") ?> USD</td></tr>
                </tbody>
            </table>
        <?php endforeach; ?>
        </div>
    </div>
</div><!--End .articles-->


<style>
    .dt-button{
        padding:5px;
        background:black;
        border:2px solid black;
        border-radius:2px;;
        color:white;
        margin-bottom:-10px;
    }
    .dt-buttons{
        margin-bottom:-25px;
    }
</style>
