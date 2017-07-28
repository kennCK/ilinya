<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Product as Item;

class ProductController extends APIController
{
  function __construct(){
    $this->model = new Item();
    $this->validation = array(
    );
    $this->notRequired = array('image', 'rice', 'barley', 'basmati_rice');
    $this->defaultValue = array(
      'rice' => 0, 'barley' => 0, 'basmati_rice' => 0
    );
  }
  public function create(Request $request){
    $this->createEntry($request->all());
    $this->response['debug'][] = $this->response['data'];
    if($this->response['data']){
      $id = $this->response['data'];
      if ($request->hasFile('image') && $request->file('image')->isValid()){

        $imagePath = $request->image->store('images');
        $this->response['debug'][] = $imagePath;
        $this->updateEntry(array(
          'id' => $this->response['data'],
          'image' => str_replace('images/', '', $imagePath)
        ));
        $this->response['data'] = $id;
      }
    }
    return $this->output();
  }
  public function update(Request $request){

    $this->updateEntry($request->all());
    if($this->response['data']){
      if ($request->hasFile('image') && $request->file('image')->isValid()){
        $imagePath = $request->image->store('images');
        $this->updateEntry(array(
          'id' => $request->input('id'),
          'image' => str_replace('images/', '', $imagePath)
        ));
      }
    }
    return $this->output();
  }
}
