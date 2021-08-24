<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use Validator;

class LocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $locations = Location::where('id_user', Auth::user()->id)->get();;

        return $this->sendResponse($locations->toArray(), 'Location retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            // широта
            'lat' => 'required|numeric|between:-91, 91',
            // долгота
            'lon' => 'required|numeric|between:-181, 181'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $location = new Location;
        $location->setCoordinate($input['lat'], $input['lon']);
        $location->name = $input['name'];
        $location->id_user = Auth::user()->id;
        
        $location->save();
   
        return $this->sendResponse($location->toArray(), 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::find($id);

        if (is_null($location)) {
            return $this->sendError('Location not found.');
        }

        return $this->sendResponse($location->toArray(), 'Location retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            // широта
            'lat' => 'required|numeric|between:-91, 91',
            // долгота
            'lon' => 'required|numeric|between:-181, 181'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $location->setCoordinate($input['lat'], $input['lon']);
        $location->name = $input['name'];
        $location->save();

        return $this->sendResponse($location, 'Location update successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return $this->sendResponse($location->toArray(), 'Product deleted successfully.');
    }
}
