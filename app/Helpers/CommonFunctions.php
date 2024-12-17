<?php

namespace App\Helpers;

class CommonFunctions
{

    public function isMaliciousFile($file)
    {
        // Check if the file extension is valid
        $validExtensions = ['jpg', 'jpeg', 'png','pdf','mp4'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $validExtensions)) {
            return true; // Malicious based on extension
        }

        // Perform additional checks, e.g., scanning the file for PHP code
        $fileContent = file_get_contents($file->getRealPath());
        if (preg_match('/<\?php/i', $fileContent)) {
            return true; // Malicious content found
        }
        if (preg_match('/<\script/i', $fileContent)) {
            return true; // Malicious content found
        }
        if (preg_match('/<\s*(script|iframe|object|embed|form|img|input)[^>]*>/i', $fileContent)) {
            return true; // Malicious content found
        }



        return false; // File is not malicious
    }
}