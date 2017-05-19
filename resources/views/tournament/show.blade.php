<!-- @author Dessaules Loïc -->

@extends('layout')

@section('content')
	<div class="container singleTournament">

		<a href="{{URL::previous()}}"><i class="fa fa-4x fa-arrow-circle-left return" aria-hidden="true"></i></a>

		<h1 class="tournamentName">
			{{ $tournament->name }}
			<a href="{{ route('tournaments.schedule.index', $tournament->id) }}" class="greenBtn big-screen" title="Affichage écran géant">Affichage écran geant</i></a>
		</h1>

		<div class="right">
			<div>
				@if(isset($tournament->sport))
					<strong>Sport :</strong> {{ $tournament->sport->name }}
				@else
					<strong>Sport :</strong> Aucun, veuillez en choisir un.
				@endif
			</div>

			<div><strong>Début du tournoi :</strong> {{ $tournament->start_date->format('d.m.Y à H:i') }}</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<table id="tournament-teams-table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Liste des équipes participantes</th>
						</tr>
					</thead>
					<tbody>
						@if(count($tournament->teams) > 0)
					  		@foreach ($tournament->teams as $team)
					  			<tr>
									<td class="clickable" data-id="{{$team->id}}">{{$team->name}}</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td>Aucune équipe pour l'instant ...</td>
							</tr>
					  	@endif
					</tbody>
				</table>
			</div>

			<div class="col-lg-6">
				<table id="tournament-courts-table" class="table table-striped table-bordered translate" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Liste des terrains</th>
						</tr>
					</thead>
					<tbody>
						@if(count($tournament->sport->courts) > 0)
							@foreach ($tournament->sport->courts as $court)
					  		<tr>
								<td class="clickable">{{$court->name}}</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td>Aucun terrain pour l'instant ...</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>

		<h2>Visualisation du tournoi</h2>

		<!-- Stages and pools -->
		@if (sizeof($tournament->pools) > 0)

			<table class="table pools">
				<thead>
					<tr>
						<th class="sizedTh"></th>
						@for ($i = 1; $i <= $totalStage; $i++)

							<th class="nav-item">
								Phase {{$i}}
							</th>

						@endfor
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="verticalText"><span>Poules</span></th>
						@for ($i = 1; $i <= $totalStage; $i++)
							<td class="noPadding">
								<table id="pools-table" class="table-hover table-striped table-bordered" width="100%" data-tournament="{{$tournament->id}}">
									<tbody>
										@foreach ($pools as $pool)
											@if ($pool->stage == $i)
											<tr>
												<td data-id="{{$pool->id}}">{{$pool->poolName}}</td>
											</tr>
											@endif
										@endforeach
									</tbody>
								</table>
							</td>
						@endfor
					</tr>


				</tbody>
			</table>
		@else
			Indisponible pour le moment ...
		@endif


@stop
