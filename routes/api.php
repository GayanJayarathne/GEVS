<?php

use App\Models\VotingStart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
    Route::get('/lead/list', 'Api\LeadController@listData');
    Route::post('/lead/create', 'Api\LeadController@create');
    Route::post('/lead/update', 'Api\LeadController@update');
    Route::post('/lead/updateVotes', 'Api\LeadController@updateVotes');
    Route::post('/lead/destroy', 'Api\LeadController@destroy');
    Route::get('/lead/listCandidateVotes', 'Api\LeadController@listCandidateVotes');
    Route::get('/lead/votesDropdown', 'Api\LeadController@votesDropdown');
    Route::get('/lead/listVotesConstituency', 'Api\LeadController@listVotesConstituency');
    Route::get('/lead/finalResults', 'Api\LeadController@finalResults');

    Route::get('/constituency/results', 'Api\LeadController@votesDropdown');

    Route::get('/dashboard-data', 'Api\HomeController@getData');
    Route::get('/party/party-dropdown', 'Api\PartyController@partiesDropdown');
    Route::get('/constituency/constituency-dropdown', 'Api\ConstituencyController@constituenciesDropdown');

    Route::get('/candidate/constituency-list', 'Api\VoterController@getDataByConstituency');

    Route::get('/votingStart/listData', 'Api\VotingStartController@listData');
    Route::post('/votingStart/create', 'Api\VotingStartController@create');
});
