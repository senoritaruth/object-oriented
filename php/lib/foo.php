<?php
namespace rcisneros\ObjectOriented;

require_once (dirname(__DIR__, 2) ."/php/Classes/Foo.php");

/** @var author $foo instantiation test **/
$foo = new author("111111111111111111111111111111111111", "", "lwefk32", "RitaLLot@gsnail.com", "alkdjfiaikjfp", "Rita Lot");

var_dump($foo);