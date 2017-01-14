<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reservation</title>
	<meta charset="utf-8" />
</head>
<body>
    <h1 class="cursive-font">Réservation</h1>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">
									
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
											<h3 class="cursive-font">Réservation d'un voiture</h3>
											<form action="traitEmpruntVehicule.php" method="POST">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="activities">Station de location</label>
														<select name="station" id="activities" class="form-control">
															<option value="">Station 1</option>
															<option value="">Station 2</option>
															<option value="">Station 3</option>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-start">Date de début</label>
														<input type="text" id="date" name="dateDeb" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-end">Heure de début</label>
														<input type="text" id="time" name="hDeb" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-start">Date de retour</label>
														<input type="text" id="date" name="dateRet" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-end">Heure de retour</label>
														<input type="text" id="time" name="hRet" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" name="valid" class="btn btn-primary btn-block" value="Véhicule(s) disponible(s)">
													</div>
												</div>
											</form>	
										</div>

										
									</div>
								</div>
							</div>
						</div>

</body>
</html>
