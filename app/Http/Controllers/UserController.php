<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'first_name' => ['bail', 'required', 'min:2', 'max:50'],
            'last_name' => ['bail', 'required', 'min:2', 'max:50'],
            'email' => ['bail', 'required', 'min:2', 'max:50', 'email'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'user_not_found'], 404);
        }

        if (request()->input('photo')) {
            $this->uploadProfilePhoto(request()->input('photo'));
        }

        $user->first_name = request()->input('first_name');
        $user->last_name = request()->input('last_name');
        $user->email = request()->input('email');
        $user->timezone = request()->input('timezone');
        $user->spoken_languages = request()->input('spoken_languages');
        $user->site_language = request()->input('site_language');
        $user->currency = request()->input('currency');

        $user->save();

        if ($user->role == 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();

            $teacher->teaching_languages = request()->input('teaching_languages');
            $teacher->about_me = request()->input('about_me');
            $teacher->country = request()->input('country') ?? 'hu';
            $teacher->video_url = request()->input('video_url');
            $teacher->one_hour_price = request()->input('one_hour_price');
            $teacher->five_hour_price = request()->input('five_hour_price');
            $teacher->ten_hour_price = request()->input('ten_hour_price');

            $teacher->save();
        }

        return redirect(route('settings'));
    }

    private function uploadProfilePhoto(UploadedFile $photo) {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->storePublicly(
                    'profile-photos', ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk() {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
