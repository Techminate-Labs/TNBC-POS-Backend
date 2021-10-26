<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blockchainController extends Controller
{
    public function __construct($index, $timestamp, $data, $previousHash=''){
        $this->$index = $index;
        $this->$timestamp = $timestamp;
        $this->$data = $data;
        $this->$previousHash = $previousHash;
        $this->hash = '';
    }

    public function calculateHash(){
        $hash = $this->$index + $this->$timestamp + $this->$previousHash + $this->$data;
        return hash('sha256', );
    }
}
