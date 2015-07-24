<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see right error masseges then input wrong date range or presaved range');

$urlList = [
  '/cb/json/?valute=usd&date1=tomorrow',
  '/cb/json/?valute=usd&date1=',
  '/cb/json/?valute=usd&date3=undefined',
  '/cb/json/?valute=usd&date1=today&date2=01/02/2014',
  '/cb/json/?valute=usd&date1=date2=01/02/2014',
  '/cb/json/?valute=usd&date2=01/02/2014',
  '/cb/json/?valute=usd&date1=01/02/2014',
  '/cb/json/?valute=usd&date1=01/02/2014&date2=1.3.2014',
  '/cb/json/?valute=usd&date1=01/02/2014&date2=1/3/2014',
  '/cb/json/?valute=usd&date1=01/02/2014&date2=1/3/14',
  '/cb/json/?valute=usd&date1=01/02/2015&date2=01/03/2014',
  '/cb/json/?valute=usd&date1=02/01/2015&date2=01/01/2015',
];


foreach ($urlList as $key => $url) {
  $I->amOnPage($url);
  $I->canSeeResponseCodeIs(200);
  $I->see('Wrong date range');
}
