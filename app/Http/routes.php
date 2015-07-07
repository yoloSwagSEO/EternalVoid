<?php
	Route::group(['domain' => '{universe}.'.Config::get('app.host'), 'middleware' => ['auth', 'universe']], function() {
		Route::controller('alliance/ranks', 'AlliancesRanksController');
        Route::controller('alliance/messages', 'AlliancesMessagesController');
        Route::controller('alliance/applications', 'AlliancesApplicationsController');
        Route::controller('json', 'JsonController');
		Route::controller('user', 'UsersController');
		Route::controller('simulator', 'SimulatorController');
		Route::controller('options', 'OptionsController');
		Route::controller('search', 'SearchController');
		Route::controller('toplist', 'ToplistController');
		Route::controller('notes', 'NotesController');
		Route::controller('reports', 'ReportsController');
		Route::controller('messages', 'MessagesController');
		Route::controller('missions', 'MissionsController');
		Route::controller('technology', 'TechnologyController');
		Route::controller('resources', 'ResourcesController');
		Route::controller('galaxy', 'GalaxyController');
		Route::controller('fleets', 'FleetsController');
		Route::controller('fleetcommand', 'FleetsController');
		Route::controller('exchange', 'ExchangeController');
		Route::controller('defense', 'DefenseController');
		Route::controller('spaceport', 'SpaceportController');
		Route::controller('shipyard', 'ShipyardController');
		Route::controller('research', 'ResearchController');
		Route::controller('buildings', 'BuildingsController');
		Route::controller('alliance', 'AlliancesController');
		Route::controller('account', 'AccountsController');
		Route::controller('planet', 'PlanetsController');
		Route::controller('/', 'PlanetsController');
	});

	Route::controller('users', 'UsersController');
	Route::controller('/', 'IndexController');
