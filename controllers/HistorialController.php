<?php
require_once __DIR__ . '/../models/Historial.php';

class HistorialController
{
    private HistorialModel $model;
    private array $historial = [];
    private string $message = '';
    private string $type = 'info';
    private ?array $registroSeleccionado = null;
    private int $ultimoId = 0;

    public function __construct(HistorialModel $model)
    {
        $this->model = $model;
    }

    public function run(): void
    {
        $this->loadMessageFromRequest();
        $this->loadHistorial();

        $action = $_REQUEST['action'] ?? null;

        if ($action === 'store' && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET')) {
            $this->handleStore();
            return;
        }

        if ($action === 'update' && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET')) {
            $this->handleUpdate();
            return;
        }

        if ($action === 'delete' && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET')) {
            $this->handleDelete();
            return;
        }

        if ($action === 'download' || $action === 'download_pdf' || $action === 'download_excel' || $action === 'download_csv') {
            $this->handleDownload($action);
            return;
        }

        if ($action === 'find') {
            $this->handleFind();
        }
    }

    public function getHistorial(): array
    {
        return $this->historial;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRegistroSeleccionado(): ?array
    {
        return $this->registroSeleccionado;
    }

    public function getUltimoId(): int
    {
        return $this->ultimoId;
    }

    private function loadMessageFromRequest(): void
    {
        if (isset($_GET['message'])) {
            $this->message = urldecode((string)$_GET['message']);
            $this->type = isset($_GET['type']) ? (string)$_GET['type'] : 'info';
        }
    }

    private function loadHistorial(): void
    {
        try {
            $this->historial = $this->model->all();
        } catch (Exception $e) {
            error_log('Error cargando historial: ' . $e->getMessage());
            $this->historial = [];
        }

        $this->ultimoId = !empty($this->historial) ? (int)($this->historial[0]['id'] ?? 0) : 0;
    }

    private function handleStore(): void
    {
        $data = [
            'fecha' => $_POST['fecha'] ?? $_GET['fecha'] ?? date('Y-m-d H:i:s'),
            'usuario' => $_POST['usuario'] ?? $_GET['usuario'] ?? 'Sistema',
            'accion' => $_POST['accion'] ?? $_GET['accion'] ?? 'Creacion desde la vista',
            'detalles' => $_POST['detalles'] ?? $_GET['detalles'] ?? 'Registro agregado desde Historial',
        ];

        try {
            $this->model->create($data);
            $this->message = 'Registro creado correctamente.';
            $this->type = 'success';
        } catch (Exception $e) {
            error_log('Error creando historial: ' . $e->getMessage());
            $this->message = 'No se pudo crear el registro.';
            $this->type = 'danger';
        }

        header('Location: index.php?menu=historial&message=' . urlencode($this->message) . '&type=' . urlencode($this->type));
        exit;
    }

    private function handleUpdate(): void
    {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? $this->ultimoId);
        if ($id <= 0) {
            $id = $this->ultimoId;
        }

        $data = [
            'fecha' => $_POST['fecha'] ?? $_GET['fecha'] ?? date('Y-m-d H:i:s'),
            'usuario' => $_POST['usuario'] ?? $_GET['usuario'] ?? 'Sistema',
            'accion' => $_POST['accion'] ?? $_GET['accion'] ?? 'Edicion desde la vista',
            'detalles' => $_POST['detalles'] ?? $_GET['detalles'] ?? 'Registro actualizado desde Historial',
        ];

        try {
            $this->model->update($id, $data);
            $this->message = 'Registro actualizado correctamente.';
            $this->type = 'warning';
        } catch (Exception $e) {
            error_log('Error actualizando historial: ' . $e->getMessage());
            $this->message = 'No se pudo actualizar el registro.';
            $this->type = 'danger';
        }

        header('Location: index.php?menu=historial&message=' . urlencode($this->message) . '&type=' . urlencode($this->type));
        exit;
    }

    private function handleDelete(): void
    {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? $this->ultimoId);
        if ($id <= 0) {
            $id = $this->ultimoId;
        }

        try {
            $this->model->delete($id);
            $this->message = 'Registro eliminado correctamente.';
            $this->type = 'danger';
        } catch (Exception $e) {
            error_log('Error eliminando historial: ' . $e->getMessage());
            $this->message = 'No se pudo eliminar el registro.';
            $this->type = 'danger';
        }

        header('Location: index.php?menu=historial&message=' . urlencode($this->message) . '&type=' . urlencode($this->type));
        exit;
    }

    private function handleDownload(string $action): void
    {
        $rows = $this->normalizeExportRows($this->historial);
        $format = $action === 'download_pdf' ? 'pdf' : ($action === 'download_excel' ? 'xlsx' : 'csv');
        $filename = 'historial_' . date('Y-m-d_H-i-s') . '.' . ($format === 'xlsx' ? 'xlsx' : ($format === 'pdf' ? 'pdf' : 'csv'));
        $filepath = __DIR__ . '/../respaldos/' . $filename;

        if (!is_dir(__DIR__ . '/../respaldos')) {
            mkdir(__DIR__ . '/../respaldos', 0755, true);
        }

        if ($format === 'csv') {
            $this->writeCsvExport($filepath, $rows);
            header('Content-Type: text/csv; charset=utf-8');
        } elseif ($format === 'xlsx') {
            $this->writeXlsxExport($filepath, $rows);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        } else {
            $this->writePdfExport($filepath, $rows);
            header('Content-Type: application/pdf; charset=utf-8');
        }

        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filepath);
        unlink($filepath);
        exit;
    }

    private function handleFind(): void
    {
        $id = (int)($_GET['id'] ?? $this->ultimoId);
        if ($id <= 0) {
            $id = $this->ultimoId;
        }

        $this->registroSeleccionado = $this->model->find($id);
        if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
            header('Content-Type: application/json');
            echo json_encode($this->registroSeleccionado ?: []);
            exit;
        }

        if ($this->registroSeleccionado) {
            $this->message = 'Registro consultado correctamente.';
            $this->type = 'info';
        } else {
            $this->message = 'No se encontró el registro solicitado.';
            $this->type = 'warning';
        }
    }

    private function normalizeExportValue($value): string
    {
        $text = trim((string)$value);
        $text = preg_replace('/[^\p{L}\p{N}\s\-_.,:\/()]/u', ' ', $text);
        $text = preg_replace('/\bcreacion\b/i', 'Creacion', $text);
        $text = preg_replace('/\baccion\b/i', 'Accion', $text);
        $text = preg_replace('/\bedicion\b/i', 'Edicion', $text);
        return $text;
    }

    private function normalizeExportRows(array $rows): array
    {
        $normalized = [];
        foreach ($rows as $row) {
            $normalized[] = [
                'id' => $this->normalizeExportValue($row['id'] ?? ''),
                'fecha' => $this->normalizeExportValue($row['fecha'] ?? ''),
                'usuario' => $this->normalizeExportValue($row['usuario'] ?? ''),
                'accion' => $this->normalizeExportValue($row['accion'] ?? ''),
                'detalles' => $this->normalizeExportValue($row['detalles'] ?? ''),
            ];
        }
        return $normalized;
    }

    private function writeCsvExport(string $filepath, array $rows): void
    {
        $handle = fopen($filepath, 'w');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, ['id', 'fecha', 'usuario', 'accion', 'detalles']);
        foreach ($rows as $row) {
            fputcsv($handle, [
                $this->normalizeExportValue($row['id'] ?? ''),
                $this->normalizeExportValue($row['fecha'] ?? ''),
                $this->normalizeExportValue($row['usuario'] ?? ''),
                $this->normalizeExportValue($row['accion'] ?? ''),
                $this->normalizeExportValue($row['detalles'] ?? '')
            ]);
        }
        fclose($handle);
    }

    private function writeXlsxExport(string $filepath, array $rows): void
    {
        $sheetRows = [['id', 'fecha', 'usuario', 'accion', 'detalles']];
        foreach ($rows as $row) {
            $sheetRows[] = [
                $this->normalizeExportValue($row['id'] ?? ''),
                $this->normalizeExportValue($row['fecha'] ?? ''),
                $this->normalizeExportValue($row['usuario'] ?? ''),
                $this->normalizeExportValue($row['accion'] ?? ''),
                $this->normalizeExportValue($row['detalles'] ?? ''),
            ];
        }

        $xmlRows = '';
        foreach ($sheetRows as $index => $rowValues) {
            $xmlCells = '';
            foreach ($rowValues as $value) {
                $escaped = htmlspecialchars((string)$value, ENT_QUOTES | ENT_XML1, 'UTF-8');
                $xmlCells .= '<c t="inlineStr"><is><t>' . $escaped . '</t></is></c>';
            }
            $xmlRows .= '<row r="' . ($index + 1) . '">' . $xmlCells . '</row>';
        }

        $sheetXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheetData>
XML;
        $sheetXml .= $xmlRows;
        $sheetXml .= '</sheetData></worksheet>';

        $contentTypesXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
</Types>
XML;

        $workbookXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="Historial" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>
XML;

        $workbookRelsXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>
XML;

        $stylesXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts>
  <fills count="1"><fill><patternFill patternType="none"/></fill></fills>
  <borders count="1"><border/></borders>
  <cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
  <cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" applyAlignment="1"><alignment horizontal="left"/></xf></cellXfs>
  <cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>
</styleSheet>
XML;

        $zip = new ZipArchive();
        $zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml', $contentTypesXml);
        $zip->addFromString('_rels/.rels', <<<'REL'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>
REL);
        $zip->addFromString('xl/workbook.xml', $workbookXml);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $workbookRelsXml);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
        $zip->addFromString('xl/styles.xml', $stylesXml);
        $zip->close();
    }

    private function writePdfExport(string $filepath, array $rows): void
    {
        $lines = ['Historial'];
        $lines[] = 'ID Fecha Usuario Accion Detalles';
        foreach ($rows as $row) {
            $lines[] = trim(implode(' ', [
                $this->normalizeExportValue($row['id'] ?? ''),
                $this->normalizeExportValue($row['fecha'] ?? ''),
                $this->normalizeExportValue($row['usuario'] ?? ''),
                $this->normalizeExportValue($row['accion'] ?? ''),
                $this->normalizeExportValue($row['detalles'] ?? '')
            ]));
        }

        $contentStream = '';
        $y = 760;
        foreach ($lines as $line) {
            $contentStream .= "BT /F1 10 Tf 50 $y Td (" . $this->escapePdfText($line) . ") Tj ET\n";
            $y -= 12;
        }

        $objects = [];
        $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
        $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
        $objects[] = "4 0 obj\n<< /Length 6 0 R >>\nstream\n" . $contentStream . "\nendstream\nendobj\n";
        $objects[] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
        $objects[] = "6 0 obj\n" . strlen($contentStream) . "\nendobj\n";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $pdf .= "xref\n0 7\n0000000000 65535 f \n";
        for ($i = 1; $i <= 6; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size 7 /Root 1 0 R >>\nstartxref\n" . strlen($pdf) . "\n%%EOF";
        file_put_contents($filepath, $pdf);
    }

    private function escapePdfText(string $value): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $value);
    }
}
