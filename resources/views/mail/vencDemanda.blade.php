@component('mail::message')
<h1>Caro Redator {{ $assunto->usuario_name }}</h1>
<p> Sua demanda <b>"{{ $assunto->assunto}}"</b> esta preste a expirar!  </p>
<p> Lembre-se de concluir as demandas dentro do prazo!! Pode ocorrer penalidades caso seja recorrente!</p>





@endcomponent