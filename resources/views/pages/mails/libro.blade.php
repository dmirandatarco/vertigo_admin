@component('mail::message')
# Libro de Reclamaciones
# Nombre:
{{$request->nombre}}
# Documento:
{{$request->numdocumento}}
# Nº Documento:
{{$request->documento}}
# Email:
{{$request->email}}
# Celular:
{{$request->celular}}
# Asunto:
{{$request->asunto}}
@component('mail::panel')
{{$request->mensaje}}
@endcomponent
@endcomponent