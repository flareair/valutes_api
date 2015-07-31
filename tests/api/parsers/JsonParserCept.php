<?php
$I = new ApiTester($scenario);
$I->wantTo('See valid json response then use json data parser');

$I->sendGET('/cb/json/?valute=usd&date1=week');
$I->canSeeHttpHeader('Content-type', 'application/json');
$I->seeResponseIsJson();

$I->sendGET('/cb/json/?valute=usd&date1=week');
$I->canSeeHttpHeader('Content-type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('//[0]/date');

$I->sendGET('/cb/json/?valute=usd&date1=15/07/2015&date2=20/07/2015');
$I->canSeeHttpHeader('Content-type', 'application/json');
$I->seeResponseIsJson();