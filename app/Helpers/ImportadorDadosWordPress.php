<?php

namespace App\Helpers;

use App\Models\Materias\Temas;
use App\Models\Dominios\TemasWordpress;
use App\Models\Materias\Materias;
use App\Models\Configuracoes\Configuracoes;
use App\Models\Dominios\Dominios;
use Carbon\Carbon;

class ImportadorDadosWordPress
{
    public function removerAcentos($texto)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $texto);
    }

    public static function carregaTemasWordPress($dominio, $idDominio)
    {
        $ultimoCaracter = substr($dominio, -1, 1);
        $dominio = ($ultimoCaracter != '/') ? $dominio . '/' : $dominio . '';
        $dadosDominio = Dominios::find($idDominio);

        $finished = false;
        $totalPagina = 1;
        while (!$finished) {
            $ch = curl_init();
            $url = $dominio . 'wp-json/wp/v2/categories?page=' . $totalPagina;

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $dados = json_decode($response);
            if (!empty($dados)) {
                foreach ($dados as $dado) {
                    $tema = Temas::where('descricao', '=', $dado->name)->get();
                    if (!isset($tema[0]['id'])) {
                        $novo = new Temas;
                        $novo->descricao = $dado->name;
                        $novo->save();

                        $novaCategoriaDominio = new TemasWordpress;
                        $novaCategoriaDominio->id_dominio = $idDominio;
                        $novaCategoriaDominio->id_tema = $novo->id;
                        $novaCategoriaDominio->id_categoria_wordpress = $dado->id;
                        $novaCategoriaDominio->save();
                    } else {
                        $categoriaDominio = TemasWordpress::where('id_tema', '=', $tema[0]['id'])
                            ->where('id_dominio', '=', $idDominio)
                            ->get();

                        if (!isset($categoriaDominio[0]['id'])) {
                            $novaCategoriaDominio = new TemasWordpress;
                            $novaCategoriaDominio->id_dominio = $idDominio;
                            $novaCategoriaDominio->id_tema = $tema[0]['id'];
                            $novaCategoriaDominio->id_categoria_wordpress = $dado->id;
                            $novaCategoriaDominio->save();
                        }
                    }
                }
            } else if (empty($dados)) {
                $finished = true;
            }

            $totalPagina++;
        }
    }

    public static function carregaPostWordPress($dominio, $idDominio)
    {
        $ultimoCaracter = substr($dominio, -1, 1);
        $dominio = ($ultimoCaracter != '/') ? $dominio . '/' : $dominio . '';
        $date = Carbon::now()->subMonth(3);
        $dadosDominio = Dominios::find($idDominio);

        $finished = false;
        $totalPagina = 1;
        while (!$finished) {
            $ch = curl_init();
            $url = $dominio . 'wp-json/wp/v2/posts?page=' . $totalPagina;

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $dados = json_decode($response);
            if (!isset($dados->data->status)) {
                $configuracao = Configuracoes::find(1);
                foreach ($dados as $dado) {
                    $idCategoria = TemasWordpress::where('id_categoria_wordpress', '=', $dado->categories[0])
                        ->where('id_dominio', '=', $idDominio)
                        ->get();

                    $idMateria = Materias::where('id_dominio', '=', $idDominio)
                        ->where('id_wordpress', '=', $dado->id)
                        ->get();

                    if (!isset($idMateria[0]['id']) && $dado->date > $date) {
                        $materia = new Materias;
                        $materia->assunto = $dado->title->rendered;
                        $materia->descricao = $dado->content->rendered;
                        $materia->tema_id = isset($idCategoria[0]['id']) ? $idCategoria[0]['id'] : null;
                        $materia->status = Materias::CODIGO_STATUS_PUBLICADO;
                        $materia->valor_post = $configuracao->valor_materia;
                        $materia->id_wordpress = $dado->id;
                        $materia->link_wordpress = $dado->link;
                        $materia->slug_wordpress = $dado->slug;
                        $materia->imagem_principal = isset($dado->yoast_head_json->og_image[0]->url) ?
                            $dado->yoast_head_json->og_image[0]->url : '';
                        $materia->id_dominio = $idDominio;
                        $materia->save();
                    }
                }
            } else if ((isset($dados->data->status)) == (isset($dados->data->status) == 400)) {
                $finished = true;
            }

            $totalPagina++;
        }
    }

    public static function cadastrarCategoriaWordPress($descricao, $idDominio, $idTema)
    {
        $dadosDominio = Dominios::find($idDominio);
        $dominio = $dadosDominio->dominio; // https://meu-app.com/
        $ultimoCaracter = substr($dominio, -1, 1); // m
        $dominio = ($ultimoCaracter != '/') ? $dominio . '/' : $dominio . '';

        $body = [
            'description' => $descricao,
            'name' => $descricao
        ];


        $ch = curl_init();
        $url = $dominio . 'wp-json/wp/v2/categories';
        $header =  array('Authorization: Basic ' . base64_encode($dadosDominio->usuario_dominio . ':' . $dadosDominio->senha_dominio), 'Content-Type: application/json',);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        $response = curl_exec($ch); // AQUI MOSTRA O RETORNO DO ERRRO OU SUCESS


        curl_close($ch);
        $dado = json_decode($response);
        $novaCategoriaDominio = new TemasWordpress();
        $novaCategoriaDominio->id_dominio = $idDominio;
        $novaCategoriaDominio->id_tema = $idTema;
        $novaCategoriaDominio->id_categoria_wordpress = $dado->id;
        $novaCategoriaDominio->save();
        return $novaCategoriaDominio->id;

        return $dado->id;
    }

    public static function cadastrarImagemWordPress($imagem, $titulo, $idDominio)
    {
        $dadosDominio = Dominios::find($idDominio);
        $dominio = $dadosDominio->dominio;
        $ultimoCaracter = substr($dominio, -1, 1);
        $dominio = ($ultimoCaracter != '/') ? $dominio . '/' : $dominio . '';

        $date = new \DateTime();
        //         $body = [
        //             "date" => $date->format('Y-m-d H:i:s'),
        //             "date_gmt" => $date->format('Y-m-d H:i:s'),
        //             "status" => "publish",
        //             "title" => str_replace(' ','-',strtolower(trim($titulo))),
        //             "description" => $titulo,
        //             "media_type" => "image",
        //             "source_url" => 'http://localhost:8000/assets/materias/imagem_materias/'.$imagem
        //         ];
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/materias/imagem_materias/' . $imagem);
        $ch = curl_init();
        $url = $dominio . 'wp-json/wp/v2/media';
        $header =  array(
            'Authorization: Basic ' . base64_encode($dadosDominio->usuario_dominio . ':' . $dadosDominio->senha_dominio),
            "cache-control: no-cache",
            'Content-Disposition: attachment; filename=' . $imagem,
            'Content-Type: image/jpg'
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        $dado = json_decode($response);




        return $dado->id;
    }

    public static function cadastrarPostWordPress($titulo, $descricao, $idTema, $idImagem, $idDominio)
    {

        $var = new ImportadorDadosWordPress();
        $dadosDominio = Dominios::find($idDominio);
        $dominio = $dadosDominio->dominio;
        $ultimoCaracter = substr($dominio, -1, 1);
        $dominio = ($ultimoCaracter != '/') ? $dominio . '/' : $dominio . '';
        date_default_timezone_set('America/Sao_Paulo');
        $date = new \DateTime();
        $slug = $var->removerAcentos($titulo);
        $body = [
            'title'   => $titulo,
            'status'  => 'publish',
            'content' => $descricao,
            'categories' => $idTema,
            'featured_media' => $idImagem,
            'date' => $date->format('Y-m-d H:i:s'),
            'slug' => str_replace(' ', '-', strtolower(trim($slug)))
        ];

        $ch = curl_init();
        $url = $dominio . '/wp-json/wp/v2/posts';
        $header =  array('Authorization: Basic ' . base64_encode($dadosDominio->usuario_dominio . ':' . $dadosDominio->senha_dominio), 'Content-Type: application/json',);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        $response = curl_exec($ch);

        curl_close($ch);
        $dado = json_decode($response);



        return $dado->id;
    }
}
