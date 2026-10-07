<?php
declare(strict_types=1);
namespace ContentFirewall\WordPress;
/** HTTP multipart boundary; local paths supplied in request parameters are never accepted. */
final class UploadedFile
{
    /** @return array{path:string,name:string,mime:string} */
    public static function fromRequest(\WP_REST_Request $request): array
    {
        $files = $request->get_file_params(); $file = $files['file'] ?? null;
        if (count($files) !== 1 || !is_array($file) || ($file['error'] ?? -1) !== UPLOAD_ERR_OK || !is_string($file['tmp_name'] ?? null) || !is_string($file['name'] ?? null) || !is_string($file['type'] ?? null) || !is_uploaded_file($file['tmp_name'])) { throw new \InvalidArgumentException('VALIDATION.UPLOAD'); }
        return ['path' => $file['tmp_name'], 'name' => $file['name'], 'mime' => $file['type']];
    }
}
