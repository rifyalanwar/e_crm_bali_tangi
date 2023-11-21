<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Rajaongkir\RajaongkirService;
use Illuminate\Http\Request;

class RajaongkirController extends Controller
{
    protected $api;

    public function __construct(RajaongkirService $rajaongkirService)
    {
        $this->api = $rajaongkirService;
    }

    public function provinces()
    {
        return $this->api->getProvince();
    }

    public function cities($province_id)
    {
        $data = $this->api->getCity($province_id);
        foreach ($data as $idx => $dt) {
            $data[$idx]['city_name'] = $data[$idx]['city_name'] . ' ' . ($data[$idx]['type'] == 'Kota' ? '(Kota)' : '');
        }
        return $data;
    }

    public function districts($city_id)
    {
        return $this->api->getDistrict($city_id);
    }

    public function cost(Request $request)
    {
        return $this->api->cost($request->origin, $request->destination, $request->weight, $request->courier);
    }
}
