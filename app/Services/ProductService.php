<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductService
{
    public function __construct()
    {
//        pathD1J2A07ZhepmP.8d5a08b007b88fe679b52dffc68e3eaec6c72caa7341e1686a2fa258a78a506d
    }

    public function getHttp(){
        // return http instance of airtable
        $http = Http::withToken('pathD1J2A07ZhepmP.8d5a08b007b88fe679b52dffc68e3eaec6c72caa7341e1686a2fa258a78a506d');
        return $http;
    }

    public function getAll(){
        $response = $this->getHttp()->get('https://api.airtable.com/v0/app3cNOhO7NDMGSbi/Product');
        return $response->json();
    }

    public function find(string $id){
        $response = $this->getHttp()->get('https://api.airtable.com/v0/app3cNOhO7NDMGSbi/Product/'.$id);
        return $response->json();
    }
}
