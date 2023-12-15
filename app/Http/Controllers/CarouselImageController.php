<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselImageRequest;
use App\Http\Resources\CarouselImageListResource;
use App\Http\Resources\CarouselImageResource;
use App\Models\CarouselImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class CarouselImageController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = CarouselImage::all();

            return CarouselImageListResource::collection($query);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch carousel images'], 500);
        }
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:2000',
            'published' => 'required|boolean',
            'image' => 'nullable|image',
        ]);

        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $validatedData['image'] ?? null;

        if ($image) {
            $relativePath = $this->saveImage($image);
            $validatedData['image'] = $relativePath;
            $validatedData['image_mime'] = $image->getClientMimeType();
            $validatedData['image_size'] = $image->getSize();
        }

        $carouselImage = CarouselImage::create($validatedData);

        return response()->json(['image' => $carouselImage], 200);
    }

    /**
     *
     * @param \App\Models\CarouselImage $carouselImage
     * @return \Illuminate\Http\Response
     */
    public function show(CarouselImage $carouselImage)
    {
        return response()->json($carouselImage);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CarouselImage      $carouselImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarouselImage $carouselImage)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:2000',
            'published' => 'required|boolean',
            'image' => 'nullable|image',
        ]);

        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $validatedData['image'] ?? null;

        if ($image) {
            $relativePath = $this->saveImage($image);
            $validatedData['image'] = $relativePath;
            $validatedData['image_mime'] = $image->getClientMimeType();
            $validatedData['image_size'] = $image->getSize();

            if ($carouselImage->image) {
                FacadesFile::deleteDirectory(public_path(dirname($carouselImage->image)));
            }
        }

        $carouselImage->update($validatedData);

        return response()->json(['image' => $carouselImage], 200);
    }

    /**
     *
     * @param \App\Models\CarouselImage $carouselImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarouselImage $carouselImage)
    {
        $carouselImage->update(['published' => false]);

        $carouselImage->delete();

        return response()->noContent();
    }


    private function saveImage(UploadedFile $image)
    {
        $path = $image->storeAs(
            'images/' . Str::random(), $image->getClientOriginalName(), 'public'
        );

        return $path;
    }
}