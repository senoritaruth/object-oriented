<?php
namespace rcisneros\ObjectOriented;

require_once (dirname(__DIR__, 1) ."/Classes/Foo.php");

/** @var author $foo instantiation test **/
$foo = new author("1471aed4-05c2-4f98-a8a2-d1302a0e8fea", "", "12345678909876543212345678909876", "RitaLLot@gsnail.com", "alkdjfiaikjfp", "Rita Lot");

var_dump($foo);