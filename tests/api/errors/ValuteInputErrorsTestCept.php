<?php
$I = new ApiTester($scenario);
$I->wantTo('see right error masseges then input wrong or not supported valute');
$I->sendGet('/cb/json/?valute=ccc&date1=today');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('This valute not in supported list');

$I->sendGet('/cb/json/?valute=123undefined&date1=today');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('This valute not in supported list');

$I->sendGet('/cb/json/?date1=today');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('You should define valute name');

$I->sendGet('/cb/json/?valute=&date1=today');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('You should define valute name');
