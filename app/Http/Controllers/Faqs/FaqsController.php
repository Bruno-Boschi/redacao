<?php
namespace App\Http\Controllers\Faqs;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Faqs\Faqs;

class FaqsController extends Controller
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
            $dados = $this->dadosFaqs($request);
            echo $dados;
            exit();
        }
        return view('faqs/index');
    }
    
    private function dadosFaqs($request)
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
        $totalRecords = Faqs::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Faqs::select('count(*) as allcount')
        ->where('titulo', 'like', '%' .$searchValue . '%')
        ->count();
        
        // Fetch records
        $records = Faqs::orderBy($columnName,$columnSortOrder)
        ->where('titulo', 'like', '%' .$searchValue . '%')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "options" => '<div class="m-icon"><a href="/faqs/create-edit/'.$record->id.'" title="Editar"><i class="me-2 mdi mdi-grease-pencil"></i></a></div>
                              <div class="m-icon"><a href="/faqs/excluir/'.$record->id.'" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>'
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
    
    public function getCreateEdit($id = 0)
    {
        $faqs = Faqs::find($id);
        return view('faqs/create-edit', compact('faqs'));
    }
    
    public function getSalvar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            if (isset($request['id'])) {
                $faqs = Faqs::find($request['id']);
                $faqs->titulo = $request['titulo'];
                $faqs->descricao = $request['descricao'];
                $faqs->save();
                $mensagem = 'Faq editada com sucesso.';
            } else {
                $faqs = new Faqs;
                $faqs->titulo = $request['titulo'];
                $faqs->descricao = $request['descricao'];
                $faqs->save();
                $mensagem = 'Faq adicionada com sucesso.';
            }
            return redirect('faqs')->with('mensagem', $mensagem);
        }
        
        return view('faqs');
    }
    
    public function getExcluir($id)
    {
        $faq = Faqs::find($id);
        $faq->delete();
        return redirect('faqs')->with('mensagem', 'Faq excluida com sucesso.');
    }
    
    public function getPesquisar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosPesquisar($request);
            echo $dados;
            exit();
        }
        return view('faqs/pesquisar');
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
        $totalRecords = Faqs::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Faqs::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->count();
        
        // Fetch records
        $records = Faqs::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "options" => '<div class="m-icon"><a href="/faqs/visualizar/'.$record->id.'" target="_blank" title="Visualizar"><i class="me-2 mdi mdi-eye-outline"></i></a></div>'
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
        $faq = Faqs::find($id);
        return view('faqs/visualizar', compact('faq'));
    }
}