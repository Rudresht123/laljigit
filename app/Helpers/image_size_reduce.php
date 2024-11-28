<?php
use Illuminate\Support\Facades\Storage;

if (!function_exists('compressImageToSize')) {
    /**
     * Compress an image to a specific size in kilobytes.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param int $maxSizeKB
     * @return string
     */
    function compressImageToSize($file, $directory, $maxSizeKB = 50)
    {
        // Generate a unique filename
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = storage_path('app/public/' . $directory . '/' . $filename);

        // Load image
        $image = imagecreatefromstring(file_get_contents($file->getRealPath()));

        // Initial quality
        $quality = 90;

        // Compress the image
        do {
            // Save the image to a temporary file
            ob_start();
            imagejpeg($image, null, $quality);
            $encodedImage = ob_get_contents();
            ob_end_clean();

            // Calculate size in KB
            $sizeKB = strlen($encodedImage) / 1024;
            $quality -= 5; // Reduce quality if necessary
        } while ($sizeKB > $maxSizeKB && $quality > 0);

        // Save the compressed image to the specified directory
        file_put_contents($path, $encodedImage);

        // Free up memory
        imagedestroy($image);

        // Return only the filename
        return $filename;
    }
}
