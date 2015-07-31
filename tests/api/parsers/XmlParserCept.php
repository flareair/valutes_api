<?php
$I = new ApiTester($scenario);
$I->wantTo('See valid xml response then use xml data parser');

$urlList = [
  '/cb/xml/?valute=usd&date1=today',
  '/cb/xml/?valute=usd&date1=week',
  '/cb/xml/?valute=usd&date1=10/05/2015&date2=12/05/2015',
  '/cb/xml/?valute=usd&date1=10/05/2015&date2=10/05/2015',
];


foreach ($urlList as $url) {
  $I->sendGET($url);
  $I->canSeeHttpHeader('Content-type', 'text/xml');
  $I->seeResponseIsXml();
  $I->seeXmlResponseMatchesXpath('//valute/record/date');
  $I->seeXmlResponseMatchesXpath('//valute/record/nominal');
  $I->seeXmlResponseMatchesXpath('//valute/record/value');
}

$I->sendGET($urlList[2]);
$I->seeXmlResponseEquals('
  <valute>
  <record>
  <date>10/05/2015</date>
  <nominal>1</nominal>
  <value>50,7511</value>
  </record>
  <record>
  <date>11/05/2015</date>
  <nominal>1</nominal>
  <value>50,7511</value>
  </record>
  <record>
  <date>12/05/2015</date>
  <nominal>1</nominal>
  <value>50,7511</value>
  </record>
  </valute>');

$I->sendGET($urlList[3]);
$I->seeXmlResponseEquals('
  <valute>
  <record>
  <date>10/05/2015</date>
  <nominal>1</nominal>
  <value>50,7511</value>
  </record>
  </valute>');