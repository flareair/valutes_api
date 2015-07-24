<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see right error masseges then input wrong date range or presaved range');

$I->amOnPage('/cb/json/?valute=usd&date1=tomorrow');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date3=undefined');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=today&date2=01/02/2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=date2=01/02/2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date2=01/02/2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=01/02/2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=01/02/2014&date2=1.3.2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=01/02/2014&date2=1/3/2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=01/02/2014&date2=1/3/14');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=01/02/2015&date2=01/03/2014');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');

$I->amOnPage('/cb/json/?valute=usd&date1=02/01/2015&date2=01/01/2015');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong date range');