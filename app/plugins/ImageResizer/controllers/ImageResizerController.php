<?php

namespace App\Plugins\ImageResizer\Controllers;

use Core\Controller;

class ImageResizerController extends Controller {

    public function index() {
        // Get the list of images
        $images = glob('public/images/*-thumbnail.*');

        // Show the upload form
        return $this->view('plugins/ImageResizer/views/index', ['images' => $images]);
    }

    public function upload() {
        $image = $_FILES['image'];

        // Check if the image was uploaded
        if ($image['error'] !== UPLOAD_ERR_OK) {
            die('Error uploading file');
        }

        // Get the image info
        $imageInfo = getimagesize($image['tmp_name']);
        if (!$imageInfo) {
            die('Invalid image file');
        }

        // Create the image resource
        $imageResource = imagecreatefromstring(file_get_contents($image['tmp_name']));

        // Define the sizes
        $sizes = [
            'thumbnail' => 150,
            'medium' => 300,
            'large' => 1024,
        ];

        // Get the original image dimensions
        $originalWidth = imagesx($imageResource);
        $originalHeight = imagesy($imageResource);

        // Loop through the sizes and resize the image
        foreach ($sizes as $name => $width) {
            // Calculate the new height
            $height = ($originalHeight / $originalWidth) * $width;

            // Create the new image
            $newImage = imagecreatetruecolor($width, $height);

            // Resize the image
            imagecopyresampled($newImage, $imageResource, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

            // Save the image
            $imageName = pathinfo($image['name'], PATHINFO_FILENAME);
            $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newImageName = "{$imageName}-{$name}.{$imageExtension}";
            imagejpeg($newImage, "public/images/{$newImageName}");
        }

        // Redirect back to the index page
        header('Location: /imageresizer');
    }
}
