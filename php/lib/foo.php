<?php
namespace rcisneros\ObjectOriented;

require_once (dirname(__DIR__, 1) ."/Classes/Foo.php");

/** @var author $foo instantiation test **/
$foo = new author("1471aed4-05c2-4f98-a8a2-d1302a0e8fea", "", "12345678909876543212345678909876", "RitaLLot@gsnail.com", "7c42507ca9950400b31aa88fd09284acf1f3968f0a6d21315b01df0fb464df66578210b6a9d38b64d8858a83a17bd2008771f09f9e078da21d7e8d82e538390e479ed1d4a025c829c48c26addb38da2a00a40a5a13c3e1beb71a7929a6594ef6ec", "Rita Lot");

var_dump($foo);