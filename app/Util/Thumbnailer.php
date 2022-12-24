<?php
namespace App\Util;

/**
 * Represents an image thumbnailer.
 */
class Thumbnailer {
    /**
     * The thumbnails directory.
     */
    const DIR_THUMBNAILS = "storage/cache/thumbs";
    
    /**
     * Thumbnail quality percentage.
     */
    const THUMB_QUALITY = 65;

    /**
     * Whether to invalidate thumbnail if source file date was changed from thumbnail.
     */
    const INVALIDATE_CHECK_FD = true;

    /**
     * Creates an ID for the specified image.
     * @param string $expr Image expression. This is usually a combination of a path and generation options.
     */
    private static function makeId($expr) {
        return hash("crc32c", $expr);
    }

    /**
     * Generates a new thumbnail for the specified path.
     * @param string $path The path of the image to generate a thumbnail for.
     * @param string $size The target size. Can be a percentage or size expression.
     */
    public static function generate($path, $size = "50%") {
        try {
            // Create paths
            $targetImagePath = getcwd() . '/' . $path;
            $targetName = Thumbnailer::DIR_THUMBNAILS . '/' . Thumbnailer::makeId($path . $size) . '.jpg';
            $cachedImagePath = getcwd() . '/' . $targetName;    

            // Check if image exists. If not, return nothing.
            if(!file_exists($targetImagePath))
                return "";

            // Generation condition
            // A new thumbnail will generate under two conditions
            // - If the thumbnail does not exist already
            // - If the source mtime > thumbnail mtime, which implies a modified source image than the one that the existing thumbnail is based on.
            if((!file_exists($cachedImagePath)) || (filemtime($targetImagePath) > filemtime($cachedImagePath))) {
                \Log::alert("[thumbcache] Regenerating thumb for " . $path);
                $imagick = new \Imagick($targetImagePath);

                // Parse size expression
                $targetHeight = 0;
                $targetWidth = 0;
                
                if(str_ends_with($size, "%")) { // Percentage (e.g. 50%)
                    $percent = intval(substr($size, 0, strlen($size) - 1));
                    $targetHeight = $imagick->getImageHeight() * ($percent / 100);
                    $targetWidth = $imagick->getImageWidth() * ($percent / 100);
                } elseif(str_contains($size, "x")) { // Size (e.g. 1920x1080)
                    $pieces = explode("x", $size);
                    $targetWidth = intval($pieces[0]);
                    $targetHeight = intval($pieces[1]);
                }

                // Use imagick to generate thumb
                $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                $imagick->setImageCompressionQuality(Thumbnailer::THUMB_QUALITY);
                $imagick->thumbnailImage($targetWidth, $targetHeight, true, true);
                $imagick->stripImage();
                $imagick->writeImage($cachedImagePath);
                $imagick->destroy();
            }

            return $targetName;
        } catch(Exception $e) {
            // Return nothing on error.
            \Log::error("[thumbcache] Generation failure: " . $e->getMessage());
            return "";
        }
    }
}
?>