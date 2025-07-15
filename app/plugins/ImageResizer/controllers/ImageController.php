<?php

use Core\Controller;

class ImageController extends Controller {

    public function resize() {
        // Get image path and dimensions from the request
        $imagePath = $this->input('path');
        $width = (int)$this->input('width');
        $height = (int)$this->input('height');

        // Validate input
        if (empty($imagePath) || $width <= 0 || $height <= 0) {
            $this->json(['error' => 'Invalid input'], 400);
            return;
        }

        // Check if the image exists
        if (!file_exists($imagePath)) {
            $this->json(['error' => 'Image not found'], 404);
            return;
        }

        // Get image info
        $imageInfo = getimagesize($imagePath);
        $mime = $imageInfo['mime'];

        // Create image resource
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            default:
                $this->json(['error' => 'Unsupported image type'], 400);
                return;
        }

        // Create a new true color image
        $resizedImage = imagecreatetruecolor($width, $height);

        // Resize the image
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

        // Output the image
        header('Content-Type: ' . $mime);
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($resizedImage);
                break;
            case 'image/png':
                imagepng($resizedImage);
                break;
            case 'image/gif':
                imagegif($resizedImage);
                break;
        }

        // Free up memory
        imagedestroy($image);
        imagedestroy($resizedImage);
    }
}
