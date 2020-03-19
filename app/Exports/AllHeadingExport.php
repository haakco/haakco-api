<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllHeadingExport implements FromCollection, WithHeadings
{
    private $collection;
    /**
     * @var null
     */
    private $headingArray;

    public function __construct(Collection $collection, $headings = null)
    {
        $this->collection = $collection;
        if (is_array($headings)) {
            $this->headingArray = $headings;
        } else {
            $first = $this->collection->first();
            $this->headingArray = array_keys($first);
        }
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return $this->headingArray;
    }
}
