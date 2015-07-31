<?php
$I = new ApiTester($scenario);
$I->wantTo('See valid json response then use json data parser');

$urlList = [
  '/cb/json/?valute=usd&date1=today',
  '/cb/json/?valute=usd&date1=week',
  '/cb/json/?valute=usd&date1=10/05/2015&date2=12/05/2015',
  '/cb/json/?valute=usd&date1=10/05/2015&date2=10/05/2015',
];


foreach ($urlList as $url) {
  $I->sendGET($url);
  $I->canSeeHttpHeader('Content-type', 'application/json');
  $I->seeResponseIsJson();
  $I->seeResponseJsonMatchesJsonPath('$.[*].date');
  $I->seeResponseJsonMatchesJsonPath('$.[*].nominal');
  $I->seeResponseJsonMatchesJsonPath('$.[*].value');
}

$I->sendGET($urlList[2]);
$I->seeResponseEquals('[{"date":"10/05/2015","nominal":"1","value":"50,7511"},{"date":"11/05/2015","nominal":"1","value":"50,7511"},{"date":"12/05/2015","nominal":"1","value":"50,7511"}]');

$I->sendGET($urlList[3]);
$I->seeResponseEquals('[{"date":"10/05/2015","nominal":"1","value":"50,7511"}]');