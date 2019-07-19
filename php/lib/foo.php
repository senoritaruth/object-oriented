<?php
namespace rcisneros\ObjectOriented;

require_once (dirname(__DIR__, 2) ."/Classes/Foo.php");

/** @var author $foo instantiation test **/
$foo = new author("abcd", null, "lwefk32", "RitaLLot@gsnail.com", "alkdjfiaikjfp", "Rita Lot");

var_dump($foo);