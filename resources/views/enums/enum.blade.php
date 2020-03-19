namespace App\Models\Enum;

class {{ $className }}
{
@foreach ($enumDataRows as $enumDataRow)
    public const {{ $enumDataRow->nameString }}_ID = {{ $enumDataRow->id }};
@if ($tableOptions['uuid'])
    public const {{ $enumDataRow->nameString }}_ENUM = '{{ $enumDataRow->uuid }}';
@endif
    public const {{ $enumDataRow->nameString }}_NAME = '{{ $enumDataRow->name }}';
@endforeach
}
