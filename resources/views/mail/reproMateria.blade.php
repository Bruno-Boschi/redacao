@component('mail::message')
<h1>Caro Redator {{ $materia->usuario_name }}</h1>
<p> Sua materia <b>"{{ $materia->assunto}}"</b> foi Reprovada  </p>
<p>Por favor, tente novamente.</p>

<br/>
<br/>
<br/>
<p> Lembre-se de concluir as demandas dentro do prazo!! Pode ocorrer penalidades caso seja recorrente!</p>





@endcomponent