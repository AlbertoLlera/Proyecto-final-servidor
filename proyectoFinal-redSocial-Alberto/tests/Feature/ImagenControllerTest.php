<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImagenControllerTest extends TestCase
{
    public function test_authenticated_user_can_upload_an_image(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('publicacion.jpg');

        $response = $this->postJson(route('imagenes.store'), [
            'file' => $file,
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['imagen']);

        $nombre = $response->json('imagen');
        Storage::disk('public')->assertExists('uploads/' . $nombre);
    }
}
