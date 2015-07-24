<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see right error masseges then go to wrong URLs');

$I->amOnPage('/');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong uri or request method');

$I->amOnPage('/wrongapiurl');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong uri or request method');

$I->amOnPage('/foobar/baz/123?date1=today');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong uri or request method');

$I->amOnPage('/cb/');
$I->canSeeResponseCodeIs(200);
$I->see('Wrong uri or request method');

$I->amOnPage('/cb/json/');
$I->canSeeResponseCodeIs(200);
$I->see('You should define valute name');

$I->amOnPage('/undefined/json/?valute=usd');
$I->canSeeResponseCodeIs(200);
$I->see('Undefined data source');

$I->amOnPage('/cb/undefined/?valute=usd');
$I->canSeeResponseCodeIs(200);
$I->see('Undefined data parser');