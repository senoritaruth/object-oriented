<?php
namespace rcisneros\ObjectOriented;

require_once (dirname(__DIR__, 1) ."/Classes/Foo.php");

/** @var author $foo instantiation test **/
$foo = new author("1471aed4-05c2-4f98-a8a2-d1302a0e8fea", "", "12345678909876543212345678909876", "RitaLLot@gsnail.com", '$argon2i$v=19$m=1024,t=384,p=2$dE55dm5kRm9DTEYxNFlFUA$nNEMItrDUtwnDhZ41nwVm7ncBLrJzjh5mGIjj8RlzVA', "Rita L Lot");

var_dump($foo);