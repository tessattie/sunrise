<div class="container" style="margin-bottom:50px">
	<div class="row">
		<div class="col-md-12">
			<div class="card" style="margin-top:20px;padding-bottom:10px">
				<div class="card-header">
			    <strong>Recherchez un Colis</strong>
			    <a class="" style="float:right;color:grey" href="<?= ROOT_DIREC ?>/customers/track"><i class="fa fa-refresh" style="color:grey;padding:0px" ></i></a>
			  </div>
			  <div class="card-body">
			  	<?= $this->Form->create(null, array("type" => "get")) ?>
			    <div class="row">
			    	<div class="col-md-11">
			    		<?= $this->Form->control('tracking_number', array('class' => 'form-control', "label" => "Numéro de Colis *", "placeholder" => "Ex: PAP123456", 'required' => true)); ?>
			    	</div>
			    	<div class="col-md-1">
			    		<?= $this->Form->button(__('Rechercher'), array('class'=>'btn btn-success', "style"=>"margin-top:24px;float:right;background:red;border-color:red")) ?>
			    	</div>
			    </div>
			    <?= $this->Form->end() ?>
			  </div>
			</div>


			<?php if(!empty($sale)) : ?>
				<div class="card" style="margin-top:20px;padding-bottom:10px">
			  <div class="card-body">
			    <div class="row">
			    	<div class="col-md-12">
			    		<table class="table table-striped">
			    			<thead>
			    				<tr>
			    					<th>Numéro Colis</th>
			    					<td class="text-right">#<?= $package->barcode ?></td>
			    				</tr>
			    				<tr>
			    					<th>Date de Création</th>
			    					<td class="text-right"><?= date("d/m/Y H:i", strtotime($sale->created)) ?></td>
			    				</tr>
			    				<tr>
			    					<th>Station de Départ</th>
			    					<td class="text-right"><?= $sale->station->name ?></td>
			    				</tr>
			    				<tr>
			    					<th>Destination</th>
			    					<td class="text-right"><?= $sale->destination_station->name ?></td>
			    				</tr>
			    				<tr>
			    					<th>Type</th>
			    					<td class="text-right"><?= $package->truck->immatriculation ?></td>
			    				</tr>
			    				<tr>
			    					<th>Commentaire</th>
			    					<td class="text-right"><?= ($package->comment) ? $package->comment : " - " ?></td>
			    				</tr>
			    			</thead>
			    		</table>

			    		<table class="table table-striped">	
		    				<thead>
		    					<tr>
		    						<th>Date</th>
		    						<th>Statut</th>
		    						<th>Station</th>
		    						<th>Vol</th>
		    						<th>Commentaire</th>
		    					</tr>
		    				</thead>
		    			
		    					<tbody>	
			    		<?php foreach($package->trackings as $tracking) : ?>
			    			<tr>
			    				<th> <?= date("d/m/Y H:i", strtotime($tracking->created)) ?></th>
			    				<td><?= $tracking->movement->name ?></td>
			    				<td><?= $tracking->station->name ?></td>
			    				<td><?= $tracking->flight->name ?></td>
			    				<td><?= $tracking->comment ?></td>
			    			</tr>
			    		<?php endforeach; ?>
			    		</tbody>
			    		</table>

			    		<?= $this->Html->image('sales/'.$package->image_path, ['style' => 'width:100%']); ?>
			    	</div>
			    </div>
			  </div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<style type="text/css">
	.text-right{
		text-align:right;
	}

	.float-right{
		float:right;
	}

	.message.error{
		background:#f8d7da;
		padding:10px;
		text-align:center;
	}
</style>