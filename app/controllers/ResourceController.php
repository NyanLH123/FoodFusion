<?php

declare(strict_types=1);

class ResourceController extends Controller
{
    public function index(): void
    {
        $this->redirect('/resources/culinary');
    }

    public function culinary(): void
    {
        $this->view('resources/index', [
            'title'     => 'Culinary Resources',
            'resources' => (new Resource())->culinary(),
            'pageType'  => 'culinary',
        ]);
    }

    public function educational(): void
    {
        $this->view('resources/index', [
            'title'     => 'Educational Resources',
            'resources' => (new Resource())->educational(),
            'pageType'  => 'educational',
        ]);
    }

    public function download(): void
    {
        $this->requireAuth();

        $resourceId    = (int) ($_GET['id'] ?? 0);
        $resourceModel = new Resource();
        $resource      = $resourceId > 0 ? $resourceModel->find($resourceId) : null;

        if (!$resource) {
            Session::flash('error', 'Resource not found.');
            $this->redirect('/resources/culinary');
        }

        // YouTube resources have no file to download — redirect to YouTube
        if ((string) $resource['type'] === 'youtube') {
            $youtubeUrl = (string) ($resource['youtube_url'] ?? '');
            if ($youtubeUrl !== '') {
                header('Location: ' . $youtubeUrl);
                exit;
            }
            Session::flash('error', 'YouTube link not available.');
            $this->redirect('/resources/culinary');
        }

        // Log the download
        (new Download())->logDownload($resourceId, (int) Auth::user()['userId']);

        $path = (string) $resource['path'];
        if (preg_match('#^https?://#', $path)) {
            header('Location: ' . $path);
            exit;
        }

        $absolute = ROOT_PATH . '/public/' . ltrim($path, '/');
        if (!is_file($absolute)) {
            Session::flash('error', 'File not available.');
            $this->redirect('/resources/culinary');
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($absolute) . '"');
        header('Content-Length: ' . filesize($absolute));
        readfile($absolute);
        exit;
    }

    public function upload(): void
    {
        $this->requireAdmin();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('/admin/uploads');
        }

        $title        = trim((string) ($_POST['title']       ?? ''));
        $description  = trim((string) ($_POST['description'] ?? ''));
        $declaredType = trim((string) ($_POST['type']        ?? 'pdf'));

        // ── YouTube resource (no file upload needed) ──────────────────────
        if ($declaredType === 'youtube') {
            $youtubeUrl = trim((string) ($_POST['youtube_url'] ?? ''));
            if ($youtubeUrl === '' || !preg_match('#^https?://(www\.)?(youtube\.com|youtu\.be)/#', $youtubeUrl)) {
                Session::flash('error', 'Please provide a valid YouTube URL.');
                $this->redirect('/admin/uploads');
            }

            (new Resource())->create([
                'title'       => $title !== '' ? $title : 'YouTube Video',
                'type'        => 'youtube',
                'description' => $description,
                'path'        => '',
                'youtube_url' => $youtubeUrl,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ]);

            Session::flash('success', 'YouTube resource added.');
            $this->redirect('/admin/uploads');
        }

        // ── File upload resource ──────────────────────────────────────────
        if (empty($_FILES['resource_file']['name'])) {
            Session::flash('error', 'Please select a file.');
            $this->redirect('/admin/uploads');
        }

        $file = $_FILES['resource_file'];
        if ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            Session::flash('error', 'Upload error.');
            $this->redirect('/admin/uploads');
        }

        $tmp  = (string) $file['tmp_name'];
        $size = (int)    $file['size'];

        // Validate MIME type — never trust extension alone
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = (string) finfo_file($finfo, $tmp);
        finfo_close($finfo);

        $map = [
            'image/jpeg'      => ['folder' => 'images', 'type' => 'image',       'max' => 5  * 1024 * 1024, 'ext' => 'jpg'],
            'image/png'       => ['folder' => 'images', 'type' => 'image',       'max' => 5  * 1024 * 1024, 'ext' => 'png'],
            'image/webp'      => ['folder' => 'images', 'type' => 'image',       'max' => 5  * 1024 * 1024, 'ext' => 'webp'],
            'video/mp4'       => ['folder' => 'videos', 'type' => 'video',       'max' => 50 * 1024 * 1024, 'ext' => 'mp4'],
            'application/pdf' => ['folder' => 'pdfs',   'type' => $declaredType === 'infographic' ? 'infographic' : 'pdf', 'max' => 10 * 1024 * 1024, 'ext' => 'pdf'],
        ];

        if (!isset($map[$mime])) {
            Session::flash('error', 'Unsupported file type. Allowed: JPG, PNG, WEBP, MP4, PDF.');
            $this->redirect('/admin/uploads');
        }

        $rule = $map[$mime];
        if ($size > $rule['max']) {
            Session::flash('error', 'File exceeds the size limit.');
            $this->redirect('/admin/uploads');
        }

        $filename = 'res_' . bin2hex(random_bytes(8)) . '.' . $rule['ext'];
        $relPath  = 'uploads/' . $rule['folder'] . '/' . $filename;
        $dest     = ROOT_PATH . '/public/' . $relPath;

        $destDir = dirname($dest);
        if (!is_dir($destDir) && !mkdir($destDir, 0775, true) && !is_dir($destDir)) {
            Session::flash('error', 'Upload directory is not writable.');
            $this->redirect('/admin/uploads');
        }

        if (!move_uploaded_file($tmp, $dest)) {
            Session::flash('error', 'Could not save file.');
            $this->redirect('/admin/uploads');
        }

        (new Resource())->create([
            'title'       => $title !== '' ? $title : $filename,
            'type'        => $rule['type'],
            'description' => $description,
            'path'        => $relPath,
            'youtube_url' => null,
            'uploaded_at' => date('Y-m-d H:i:s'),
        ]);

        Session::flash('success', 'Resource uploaded.');
        $this->redirect('/admin/uploads');
    }
}
