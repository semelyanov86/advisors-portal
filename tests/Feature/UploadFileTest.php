<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\UploadFileAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UploadFileTest extends TestCase
{
    /**
     * @test
     * @see UploadFileAction
     */
    public function testFileUploadAction(): void
    {
        $file = UploadedFile::fake()->create('test.png', 100, 'image/png');
        $action = app(UploadFileAction::class);
        $result = $action($file);
        $this->assertFileExists(storage_path('app/public/uploads/tmp/' . $result . '/test.png'));
        $this->assertNotEquals('', $result);
        $this->assertDatabaseHas('temporary_files', [
            'folder' => $result
        ]);
    }

    public function testFileUploadRoute(): void
    {
        $file = UploadedFile::fake()->create('test.png', 200, 'image/png');
        $response = $this->post(route('fileUpload'), [
            'file_upload' => $file
        ], [
            'Accept' => 'application/vnd.api+json'
        ]);
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('data', fn(AssertableJson $json) =>
            $json
                ->has('id')
                ));
    }

    public function testFileValidationMimeType(): void
    {
        $file = UploadedFile::fake()->create('test.pdf', 400, 'aplication/pdf');
        $response = $this->post(route('fileUpload'), [
            'file_upload' => $file
        ], [
            'Accept' => 'application/vnd.api+json'
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "errors" => [
                [
                    "title" => "Validation Error",
                    "details" => "The file upload must be a file of type: jpg, png, bmp, pdf.",
                    "source" => [
                        "pointer" => "/file_upload"
                    ]
                ]
            ]
        ]);
    }

    public function testFileSizeValidation(): void
    {
        $file = UploadedFile::fake()->create('test.png', 4000, 'image/png');
        $response = $this->post(route('fileUpload'), [
            'file_upload' => $file
        ], [
            'Accept' => 'application/vnd.api+json'
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "errors" => [
                [
                    "title" => "Validation Error",
                    "details" => "The file upload must not be greater than 2040 kilobytes.",
                    "source" => [
                        "pointer" => "/file_upload"
                    ]
                ]
            ]
        ]);
    }
}
