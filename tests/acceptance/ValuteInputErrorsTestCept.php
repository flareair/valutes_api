<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see right error masseges then input wrong or not supported valute');
$I->amOnPage('/cb/json/?valute=ccc&date1=today');
$I->canSeeResponseCodeIs(200);
$I->see('This valute not in supported list');

$I->amOnPage('/cb/json/?valute=123undefined&date1=today');
$I->canSeeResponseCodeIs(200);
$I->see('This valute not in supported list');

$I->amOnPage('/cb/json/?date1=today');
$I->canSeeResponseCodeIs(200);
$I->see('You should define valute name');

$I->amOnPage('/cb/json/?valute=&date1=today');
$I->canSeeResponseCodeIs(200);
$I->see('You should define valute name');
