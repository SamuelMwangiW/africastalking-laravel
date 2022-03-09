<?php

use function Pest\Faker\faker;

dataset('strings',function (){
    yield faker()->word();
    yield faker()->word();
    yield faker()->word();
    yield faker()->word();
    yield faker()->word();
});
