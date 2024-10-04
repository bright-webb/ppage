<?php

namespace App\Livewire;
use Livewire\WithFileUploads;
use App\Models\Templates;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Illuminate\Support\Str;


class UploadTemplate extends Component
{
    use WithFileUploads;
    public $name;
    public $description;
    public $file;

    public $user;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'file' => 'required|file|mimes:zip|max:20248',
    ];

    public function mount($user){
        $this->user = $user;
    }
    public function uploadTemplate(){
        $this->validate($this->rules);

        $requiredVariables = ['{{$name}}', '{{$email}}'];
        $tempPath = storage_path('app/temp/' . $this->name . '/');
        $extractPath = storage_path('app/templates/' . $this->name. '/');
    
        try {
            $zip = new ZipArchive;
            if ($zip->open($this->file->getRealPath()) !== TRUE) {
                throw new \Exception('Failed to open the zip file');
            }
    
            $zip->extractTo($tempPath);
            $zip->close();

            $this->validateRequiredFiles($tempPath);
    
            $this->renameIndexFile($tempPath);
    
            // $this->checkRequiredVariables($tempPath . '/index.blade.php', $requiredVariables);
    
            $schema = $this->validateSchemaJson($tempPath . '/schema.json');
    
            $thumbnail = $this->processScreenshot($tempPath, $this->name);

            File::moveDirectory($tempPath, $extractPath);

            $template = new Templates();
            $template->name = $this->name;
            $template->slug = Str::slug($this->name);
            $template->developer_id = $this->user;
            $template->file_path = $extractPath;
            $template->thumbnail = $thumbnail;
            $template->schema = $schema;
            $template->status = 'pending';
            $template->description = $this->description ?? null;
            // $template->is_free = $this->is_free ?? false;
            // $template->price = $this->is_free ? null : $this->price;

            $template->save();
    
            session()->flash('message', 'Template uploaded successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        } finally {
           
            File::deleteDirectory($tempPath);
        }
    
    }


private function validateRequiredFiles($path)
{
    $requiredFiles = ['index.html', 'schema.json', 'screenshot.png'];
    foreach ($requiredFiles as $file) {
        if (!file_exists($path . '/' . $file)) {
            throw new \Exception($file . ' is missing');
        }
    }
}

private function renameIndexFile($path)
{
    $htmlPath = $path . '/index.html';
    $bladePath = $path . '/index.blade.php';
    if (!rename($htmlPath, $bladePath)) {
        throw new \Exception('Failed to rename file');
    }
}

private function checkRequiredVariables($filePath, $requiredVariables)
{
    $content = file_get_contents($filePath);
    $missingVariables = array_filter($requiredVariables, function($var) use ($content) {
        return !Str::contains($content, $var);
    });

    if (!empty($missingVariables)) {
        throw new \Exception('Missing variables: ' . implode(', ', $missingVariables));
    }
}

private function validateSchemaJson($schemaPath)
{
    $schemaContents = file_get_contents($schemaPath);
    $decoded = json_decode($schemaContents, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception('Invalid schema.json format');
    }
    
    return $schemaContents; 
}

private function processScreenshot($path, $name)
{
    $screenshot = $path . '/screenshot.png';
    if (file_exists($screenshot)) {
        $thumbnailFile = $name . '_thumbnail.png';
        Storage::put('public/thumbnails/' . $thumbnailFile, file_get_contents($screenshot));
        return 'public/thumbnails/' . $thumbnailFile;
    } else {
        throw new \Exception('Screenshot image not found');
    }
}
}