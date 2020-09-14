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

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left;height:45px")) ?>
                    </div>
                    <div class="col-md-8"></div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    <div class="panel-body articles-container" style="padding-top:75px">
    <?php foreach($closing as $report) : ?>
            <table class="table table-bordered datatable">
                <thead>
                <tr><th colspan="3"><?= $report['user'] ?></th></tr>
                    <tr><th>Type</th><th class="text-center">HTG</th><th class="text-center">USD</th></tr>
                </thead>
                <tbody>
                
                    <tr><th>Cash</th><td class="text-center"><?= number_format($report['cash_htg'], 2, ".", ",") ?> HTG</td> <td class="text-center"><?= number_format($report['cash_usd'], 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Chèque </th> <td class="text-center"><?= number_format($report['cheque_htg'], 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($report['cheque_usd'], 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Crédit </th> <td class="text-center"><?= number_format($report['credit_htg'], 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($report['credit_usd'], 2, ".", ",") ?> USD</td></tr>
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
