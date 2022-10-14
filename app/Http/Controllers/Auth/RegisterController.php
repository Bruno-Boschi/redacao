<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Painel\Domain;
use Helper;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    use RegistersUsers;

    protected $redirectTo = '/painel';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator(array $data) {            
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create() {
        $data['name'] = $data['name'].' '.$data['sobrenome'];
        unset($data['sobrenome']);

        $last = User::orderBy('id','desc')->first('gerente_contas');
        
        if($last->gerente_contas){
            $gerentes = User::join('role_user','users.id','role_user.user_id')
                        ->where('role_user.role_id','9')
                        ->whereNotIn('users.id',[$last->gerente_contas])
                        ->inRandomOrder()
                        ->first('id');
        } else {
            $gerentes = User::join('role_user','users.id','role_user.user_id')
                        ->where('role_user.role_id','9')
                        ->inRandomOrder()
                        ->first('id');
        }

        if(!isset($data['gerente_contas'])){
            $data['gerente_contas'] = $gerentes->id;
        }
    

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'afiliados' => $data['afiliados'],
            'gerente_contas'=>$data['gerente_contas'],
            'id_user_type' => 2,
            'password' => Hash::make($data['password']),
        ]);

        foreach($data['domains'] as $domain){
          $domain['id_user'] = $user->id;
            $str = str_replace('http://','',$domain['name']);
            $str = str_replace('https://','',$str);
          $domain['name'] =  $str;
          Domain::create($domain);
        }

        $user->syncRoles([2]);
        session(['CadastradoSucesso' => 1]);
        return $user;
    }
}