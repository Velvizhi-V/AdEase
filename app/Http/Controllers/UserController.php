<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function dashboard()
    {
        // Your logic for retrieving advertisement details and template design here
        $advertisementId = 1; // Replace with your logic to get the actual advertisement ID

        // Generate QR Code with a dynamic URL
        $dynamicURL = 'https://example.com/advertisement/' . $advertisementId;
        $qrCode = QrCode::size(300)->generate($dynamicURL);

        // Load the template design image
        $templatePath = public_path('path/to/your/template.jpg'); // Adjust the path accordingly
        $template = Image::make($templatePath);

        // Insert QR Code onto the template design
        $template->insert($qrCode, 'bottom-right', 10, 10);

        // Save or display the final image
        $imagePath = 'adversitements\final_image.png'; // Adjust the path accordingly
        $template->save(public_path($imagePath));

        // Return the view or redirect
        return view('user.dashboard', compact('imagePath'));
    }
}
