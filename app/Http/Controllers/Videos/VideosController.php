<?php
namespace App\Http\Controllers\Videos;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Videos\Videos;

class VideosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Factory $validator) {
        $this->request = $request;
        $this->validator = $validator;
        $this->middleware('auth');
    }
    
    public function show($id)
    {
        //
    }
    
    public function getIndex()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosDepartamento($request);
            echo $dados;
            exit();
        }
        return view('videos/index');
    }
    
    private function dadosDepartamento($request)
    {
        ## Read value
        $draw = $request['draw'];
        $start = $request['start'];
        $rowperpage = $request['length']; // Rows display per page
        
        $columnIndex_arr = $request['order'];
        $columnName_arr = $request['columns'];
        $order_arr = $request['order'];
        $search_arr = $request['search'];
        
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        // Total records
        $totalRecords = Videos::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Videos::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->count();
        
        // Fetch records
        $records = Videos::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "options" => "<div class='m-icon'><a href='#dialog1' onclick='abrirModal(".$record->id.")' title='Cadastrar' name='modal'><i class='me-2 mdi mdi-pencil'></i></a></div>
                              <input type='hidden' id='video_".$record->id."' value='".$record->video."'>
                              <input type='hidden' id='titulo_".$record->id."' value='".$record->titulo."'>
                              <div class='m-icon'><a href='/videos/excluir/".$record->id."' title='Excluir'><i class='me-2 mdi mdi-delete'></i></a></div>"
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        
        return json_encode($response);
    }
    
    public function postSalvarVideo()
    {
        $request = $this->request->all();
        if (empty($request['idVideo'])) {
            $video = new Videos;
            $video->titulo = $request['titulo'];
            $video->video = $request['video'];
            $video->save();
        } else {
            $video = Videos::find($request['idVideo']);
            $video->titulo = $request['titulo'];
            $video->video = $request['video'];
            $video->save();
        }
        echo json_encode(array('status' => 1));
        exit;
    }
    
    public function getExcluir($id)
    {
        $video = Videos::find($id);
        $video->delete();
        return redirect('videos')->with('mensagem', 'Vídeo excluido com sucesso.');
    }
    
    public function getPesquisar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosPesquisar($request);
            echo $dados;
            exit();
        }
        return view('videos/pesquisar');
    }
    
    private function dadosPesquisar($request)
    {
        ## Read value
        $draw = $request['draw'];
        $start = $request['start'];
        $rowperpage = $request['length']; // Rows display per page
        
        $columnIndex_arr = $request['order'];
        $columnName_arr = $request['columns'];
        $order_arr = $request['order'];
        $search_arr = $request['search'];
        
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        // Total records
        $totalRecords = Videos::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Videos::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->count();
        
        // Fetch records
        $records = Videos::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "options" => '<div class="m-icon"><a href="/videos/visualizar/'.$record->id.'" target="_blank" title="Visualizar"><i class="me-2 mdi mdi-eye-outline"></i></a></div>'
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        
        return json_encode($response);
    }
    
    public function getVisualizar($id)
    {
        $videos = Videos::find($id);
        return view('videos/visualizar', compact('videos'));
    }
}