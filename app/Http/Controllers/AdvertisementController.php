<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class AdvertisementController extends Controller
{
    public function create()
    {
        return view('advertisements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $advertisement = Advertisement::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('advertisements/images', 'public');
            $advertisement->update(['image' => $imagePath]);
        }

        // Generate QR Code
        $qrCodeContent = route('advertisements.show', $advertisement->id);
        $qrCode = QrCode::size(300)->generate($qrCodeContent);

        Log::info('QR Code Content: ' . $qrCodeContent);
        // Load template image using asset
        $templatePath = public_path('images/template.png');
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template image not found at ' . $templatePath]);
        }

        $template = Image::make($templatePath);
        $qrImage = Image::make($qrCode);
        Log::info('QR Code Content12: ' . $qrImage);
        // Log information before inserting QR Code
        Log::info('Before inserting QR Code into template');

        // Insert QR Code into template manually
        $template->insert($qrImage, 'bottom-right', 10, 10);

        // Log information after inserting QR Code
        Log::info('After inserting QR Code into template');

        // Save the final image
        $finalImagePath = 'advertisements/final_image.png'; // Adjust the path as needed
        $template->save(public_path($finalImagePath));

        return redirect()->route('advertisements.download', $advertisement->id);
    }

    public function download($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $finalImagePath = public_path('advertisements/final_image.png');
        $headers = ['Content-Type' => 'image/png'];

        return response()->download($finalImagePath, 'final_image.png', $headers);
    }

    public function edit($id)
    {
        $advertisement = Advertisement::findOrFail($id);

        return view('advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $advertisement = Advertisement::findOrFail($id);
        $advertisement->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        if ($request->hasFile('image')) {
            // Delete the existing image if any
            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }

            // Upload the new image
            $imagePath = $request->file('image')->store('advertisements/images', 'public');
            $advertisement->update(['image' => $imagePath]);
        }

        // Implement QR Code and template logic here...

        Session::flash('success', 'Advertisement Edited successfully.');

        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $advertisement->delete();

        // Implement logic for deleting associated files if needed...

        return redirect()->route('home')->with('success', 'Advertisement deleted successfully.');
    }
}
