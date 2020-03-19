export enum Enum{{ str_plural($enumName) }} {
@foreach($dataArray as $uuid => $name)
    {{ strtoupper(str_replace(' ', '_', $name)) }}_NAME = '{{ $name }}',
    {{ strtoupper(str_replace(' ', '_', $name)) }}_ID = '{{ $uuid }}',
@endforeach
}
