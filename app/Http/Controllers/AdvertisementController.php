<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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

        // Implement QR Code and template logic here...

        // Generate dynamic QR Code URL
        $qrCodeUrl = route('advertisements.show', $advertisement->id);

        // Generate QR Code image
        $qrCodeImage = $this->generateQrCode($qrCodeUrl);

        // Get the template design image (assuming it's stored in public/template.jpg)
        $templateImagePath = public_path('template.jpg');

        // Open the template design image using Intervention Image
        $templateImage = Image::make($templateImagePath);

        // Append QR Code image to the template design image
        $templateImage->insert($qrCodeImage, 'bottom-right', 10, 10);

        // Save the final image
        $finalImagePath = 'advertisements/final_image.png';
        $templateImage->save(public_path($finalImagePath));

        // Update the advertisement with the final image path
        $advertisement->update(['image' => $finalImagePath]);

        return redirect()->route('advertisements.download', $advertisement->id);
    }

    private function generateQrCode($url)
    {
        $qrCode = QrCode::format('png')->size(200)->generate($url);

        $dataUri = 'data:image/png;base64,' . base64_encode($qrCode);

        return Image::make($dataUri);
    }
    public function download($id)
    {
        $advertisement = Advertisement::findOrFail($id);

        // Implement logic to fetch the final image path based on $advertisement->id

        $imagePath = 'adversitements\final_image.png'; // Replace with your logic

        return response()->download(public_path($imagePath));
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

        return redirect()->route('home');;
    }
    public function destroy($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $advertisement->delete();

        // Implement logic for deleting associated files if needed...

        return redirect()->route('home')->with('success', 'Advertisement deleted successfully.');
    }
}
