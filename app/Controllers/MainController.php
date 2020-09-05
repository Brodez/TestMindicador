<?php namespace App\Controllers;

use App\Models\UFModel;
use Carbon\Carbon;
use CodeIgniter\API\ResponseTrait;
use Carbon\CarbonPeriod;

class MainController extends BaseController
{
	use ResponseTrait;

	//Vista inicial donde va la grafica
	//Para poder visualizar los datos estos deben ser en rango, pero MiIndicador solo tiene por Año o fecha exacta
	//La opcion mas viable sin recargar todo y colapsar con tantas consultas, es hacerlo por año e irlos agregando.
  public function index()
  {

    helper('html');
    echo view('miIndicador/index', ['title' => 'Principal']);
  }

  public function index_uf()
  {

		helper('html');
		$data = ['title' =>'Historico UF'];


    echo view('miIndicador/UF/index', $data);
	}

	public function get_ufs(){
		$db      = \Config\Database::connect();
		$query = $db->query('SELECT id, fecha, valor FROM uf');
		$datos = [];

		foreach ($query->getResultArray() as $key => $r) {
			$row = [];
			$row['id'] = $r['id'];
			$row['fecha'] = $r['fecha'];
			$row['valor'] = $r['valor'];
			$datos['data'][] = $row;
		}

		echo json_encode($datos);
	}

	public function load_uf(){
		//Actualizar los valores de la UF obtenidos de miIndicador, como no tengo los valores para ser modificados debo llenarlos con datos
		$fecha_inicial = Carbon::createFromDate("1977","1","1");
		$fecha_termino = Carbon::now();
		$ran = range($fecha_inicial->format('Y'), $fecha_termino->format('Y'));
		rsort($ran);

		$UFModel = new UFModel();	

		//Para poder llenar la base de datos, se debe obtener solo por Año ya que la api de Mindicador no es por fecha en rango, si no por fecha exacta o por año, por ende por año es mejor para solamente hacer una sola consulta y compararla con la base de datos.

		//Tener en cuenta que no debe reemplazar los existenes y tambien no debe agregar uno ya existente.

		foreach ($ran as $key => $año) {
			$opts = array('http'=>array('header' => "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"));
			$context = stream_context_create($opts);

			$apiUrl = 'https://mindicador.cl/api/uf/' . $año;
			//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
			$json = "";
			if ( ini_get('allow_url_fopen') ) {
					$json = file_get_contents($apiUrl, false, $context);
			} else {
					//De otra forma utilizamos cURL
					$curl = curl_init($apiUrl);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($curl);
					curl_close($curl);
			}

			$jsonDecoded = json_decode($json);
			$break = false;

			foreach ($jsonDecoded->serie as $key => $e) {
				$fecha = new Carbon($e->fecha);
				$fecha = $fecha->format('Y-m-d');
				$valor = $e->valor;
				$exist = $UFModel->where('fecha',$fecha)->first();
				if(is_null($exist)){
					$data = [
						'fecha' => $fecha,
						'valor' => $valor
					];
					$UFModel->insert($data);
				}
				else{
					break;
					$break = true;
				}

				// dd($fecha->format('Y-m-d'));
			}

			if($break){
				break;
			}
		}

		return redirect()->route('historico-uf');
	
	}

	public function get_uf($id) {
		$UFModel =  new UFModel();
		$data = $UFModel->find($id);
		echo json_encode($data);
	}
	
	public function update_uf() {

		$UFModel = new UFModel();
		$values = $this->request;
		$data = [
				'valor' => $values->getPost('uf_valor'),
		];
		$UFModel->update($values->getPost('uf_id'), $data);
		echo json_encode(array("status" => TRUE));
	}

  //--------------------------------------------------------------------

}
