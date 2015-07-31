<?php
$I = new ApiTester($scenario);
$I->wantTo('see right error masseges then go to wrong URLs');

$validUri = '/cb/xml/?valute=usd&date1=10/05/2015&date2=12/05/2015';

$I->sendGet('/');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Wrong uri or request method');

$I->sendPut($validUri);
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Wrong uri or request method');


$I->sendPost($validUri);
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Wrong uri or request method');


$I->sendGet('/wrongapiurl');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Wrong uri or request method');

$I->sendGet('/foobar/baz/123?date1=today');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Wrong uri or request method');

$I->sendGet('/cb/');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Wrong uri or request method');

$I->sendGet('/cb/json/');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('You should define valute name');

$I->sendGet('/undefined/json/?valute=usd');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Undefined data source');

$I->sendGet('/cb/undefined/?valute=usd');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('Undefined data parser');