@component('mail::message')
<h1>Bruno</h1>
<p> PARABÉNS!!!!</p>
<p> Seu Cadastro foi aprovado!</p>
<p> Acesse para continuar.</p>
@component('mail::button', ['url' => config('app.url')])
Acessar
@endcomponent
@endcomponent
