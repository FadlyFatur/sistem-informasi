<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class dropzoneController extends Controller
{
    public function galeri()
    {
        $images = \File::allFiles(public_path('images'));
        return view('pencarian.galeri',compact('images'));
    }

    public function index()
    {
        if(!empty(Auth::user()->verified_at)){
            return view('manajemen.crudGaleri');
        }else{
            return redirect('profil')->with(['gagal' => 'Akun belum terverifikasi, Harap hubungi admin untuk verifikasi']);
        }
    }

    public function upload(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();
   
        $upload_success = $image->move(public_path('images'), $imageName);
   
        if( $upload_success ) {
            return Response::json(['success' => $imageName], 200);
         } else {
            return Response::json('error', 400);
         }
    }

    public function fetchGaleri()
    {
        
        // $output = '<div class="gallery gallery-md text-center">';
        // foreach($images as $image){
        //     $output .= '
        //     <div class="gallery-item" data-image="'.asset('images/' . $image->getFilename()).'" data-title="Image 1" href="'.asset('images/' . $image->getFilename()).'" style="background-image: url(&quot;'.asset('images/' . $image->getFilename()).'&quot;);">
        //     </div>
        //     ';
        // }
        // $output .= '</div>';
        // echo $output;
    }

    function fetch(){

        $images = \File::allFiles(public_path('images'));
        $output = '<div class="gallery gallery-md text-center">';
        foreach($images as $image)
        {
        $output .= '
        <div class="gallery-item" data-image="'.asset('images/' . $image->getFilename()).'" data-title="Image 1" href="'.asset('images/' . $image->getFilename()).'" style="background-image: url(&quot;'.asset('images/' . $image->getFilename()).'&quot;); height:150px; width:150px;">
        <button type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'">Hapus</button>
        </div>
        ';
        }
        $output .= '</div>';
        echo $output;
        }

        function delete(Request $request){
        if($request->get('name'))
        {
        \File::delete(public_path('images/' . $request->get('name')));
        }
    }
}
