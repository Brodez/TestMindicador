<?php namespace App\Controllers;

use App\Models\UFModel;

class MainController extends BaseController
{
  public function index()
  {
    helper('html');
    echo view('miIndicador/index', ['title' => 'Principal']);
  }

  public function index_uf()
  {
    $UFModel = new UFModel();
    $UF = $UFModel->findAll();
    dd($UF);
    helper('html');
    echo view('miIndicador/UF/index', ['title' => 'Historico UF']);
  }

  public function add()
  {
    helper('html');
    echo view('miIndicador/UF/index', ['title' => 'Historico UF']);
  }

  //--------------------------------------------------------------------

}
