<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\FindAndAttachFileAction;
use App\Actions\UploadFileAction;
use App\Models\Advisor;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class ReceivingFileTest extends TestCase
{
    public function testGetAndAttachFileToModel(): void
    {
        $this->signInAsAdmin();
        $advisor = Advisor::factory()->createOne();
        $file = UploadedFile::fake()->create('test.png', 100, 'image/png');
        $action = app(UploadFileAction::class);
        $folder = $action($file);
        $action = app(FindAndAttachFileAction::class);
        $result = $action($folder, $advisor);
        $advisor->refresh();
        $this->assertTrue($result);
        $media = $advisor->getFirstMedia('profile');
        $this->assertInstanceOf(Media::class, $media);
        $this->assertEquals('test.png', $media->file_name);
    }
}
