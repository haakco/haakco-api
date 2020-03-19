<?php

namespace App\Libraries\Export;

use App\Exports\AllExport;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception as ExceptionPhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception as ExceptionPhpSpreadsheetWriter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportLibrary
{
    /**
     * @param       $result
     * @param array $options
     *
     * @return ResponseFactory|Response
     */
    public function resultToXML($result, array $options = [])
    {
        $headers = $options['headers'] ?? [];

        $xml = new \SimpleXMLElement('<result/>');

        foreach ($result as $row) {
            $item = $xml->addChild('item');

            if (count($headers)) {
                foreach ($headers as $id => $heading) {
                    $item->addChild(
                        strtolower(
                            htmlspecialchars(
                                str_replace(
                                    ' ',
                                    '_',
                                    str_replace(
                                        '(',
                                        '',
                                        str_replace(
                                            ')',
                                            '',
                                            $heading
                                        )
                                    )
                                )
                            )
                        ),
                        htmlspecialchars(
                            $row[$id]
                        )
                    );
                }
            } else {
                foreach ($row as $heading => $rowItem) {
                    $item->addChild(
                        strtolower(
                            htmlspecialchars(
                                str_replace(
                                    ' ',
                                    '_',
                                    str_replace(
                                        '(',
                                        '',
                                        str_replace(
                                            ')',
                                            '',
                                            $heading
                                        )
                                    )
                                )
                            )
                        ),
                        htmlspecialchars(
                            $rowItem
                        )
                    );
                }
            }
        }

        $fileName = $options['fileName'] . '.xml';

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }

    /**
     * @param       $result
     * @param array $options
     *
     * @return BinaryFileResponse|BinaryFileResponse
     * @throws ExceptionPhpSpreadsheet
     * @throws ExceptionPhpSpreadsheetWriter
     */
    public function resultToCSV($result, array $options = []): BinaryFileResponse
    {
        $fileName = $options['fileName'] . '.csv';

        if (!($result instanceof Collection)) {
            $result = collect($result);
        }
        return Excel::download(new AllExport($result), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * @param       $result
     * @param array $options
     *
     * @return mixed
     * @throws ExceptionPhpSpreadsheet
     * @throws ExceptionPhpSpreadsheetWriter
     */
    public function resultToExcel($result, array $options = [])
    {
        $fileName = $options['fileName'] . '.xlsx';

        if (!($result instanceof Collection)) {
            $result = collect($result);
        }

        return Excel::download(new AllExport($result), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * @param Request $request
     * @param         $data
     * @param array $options
     *
     * @return ResponseFactory|JsonResponse|Response|mixed|BinaryFileResponse
     * @throws ExceptionPhpSpreadsheet
     * @throws ExceptionPhpSpreadsheetWriter
     */
    public function resultTypeFromRequest(Request $request, $data, array $options = [])
    {
        $exportType = $request->get('export_type', $options['defaultExportType']);

        if (
            \is_array($data) &&
            $exportType !== null &&
            isset($data['data'])
        ) {
            $data = $data['data'];
        }

        $options['fileName'] = $options['fileName'] ?? 'report';

        if (array_key_exists('collapse', $options) && in_array($exportType, ['excel', 'csv', 'xml'])) {
            $data = $this->collapseData($data, $options);
        }

        //header for angular access
        header('Access-Control-Expose-Headers: *');

        switch ($exportType) {
            case 'excel':
                return $this->resultToExcel($data, $options);
                break;
            case 'xml':
                return $this->resultToXML($data, $options);
                break;
            case 'csv':
                return $this->resultToCSV($data, $options);
                break;
            case 'json':
            default:
                return response()->json($data);
                break;
        }
    }

    /**
     * @param       $result
     * @param array $options
     *
     * @return array
     */
    private function collapseData(Collection $result, array $options): array
    {
        return $result->map(function ($row) use ($options) {
            foreach ($options['collapse'] as $key => $mapFrom) {
                $temp = $row->{$key};
                unset($row->{$key});
                $row->{$key} = $temp->{$mapFrom} ?? '';
            }
            return $row;
        })
            ->toArray();
    }
}
