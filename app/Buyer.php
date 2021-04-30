<?php

namespace App;

class Buyer extends User
{
    public function transactions(){
        return $this->hasmany('App\Transaction');
    }
}
