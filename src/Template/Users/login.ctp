<div class="row" style="margin-top:3%">
	<div class="col-md-4 col-md-offset-4">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Connexion</div>
			<div class="panel-body">
				<?= $this->Form->create() ?>
					<fieldset>
						<div class="form-group">
							<?= $this->Form->control("username", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Nom d'Utilisateur")) ?>
						</div>
						<div class="form-group">
							<?= $this->Form->control("password", array('label' => false, "class" => "form-control loginForm", "placeholder" => "Mot de Passe")) ?>
						</div>
						<?= $this->Flash->render() ?>
                		<?= $this->Form->button("Submit", array('class' => "btn btn-success loginForm")) ?>
                		<a href="<?= ROOT_DIREC ?>/users/forgotpassword" style="float:right;margin-top:5px">Oublie Mot de passe</a>
            		<?= $this->Form->end() ?>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->	