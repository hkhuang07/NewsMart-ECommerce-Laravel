<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Http\RedirectResponse;
=======
>>>>>>> 1679f750720f54699398b3e923803854f3198352

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to access configuration management.');
        }

        $configurations = Configuration::orderBy('settingkey', 'asc')->get();
        return view('configurations.index', compact('configurations'));
=======
        //
>>>>>>> 1679f750720f54699398b3e923803854f3198352
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to add configurations.');
        }

        // Validation
        $request->validate([
            'settingkey' => ['required', 'string', 'max:100', 'unique:configurations,settingkey'],
            'settingvalue' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $config = new Configuration();
        $config->settingkey = $request->settingkey;
        $config->settingvalue = $request->settingvalue;
        $config->description = $request->description;
        $config->save();

        return redirect()->route('configuration')->with('success', 'Configuration created successfully!');
    }

    public function getUpdate($settingkey)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to edit configurations.');
        }

        $config = Configuration::findOrFail($settingkey);
        return view('configurations.update', compact('config'));
    }

    public function postUpdate(Request $request, $settingkey)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to edit configurations.');
        }

        $config = Configuration::findOrFail($settingkey);

        // Validation
        $request->validate([
            'settingkey' => ['required', 'string', 'max:100', 'unique:configurations,settingkey,' . $settingkey . ',settingkey'],
            'settingvalue' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        // Nếu đổi khóa chính
        if ($request->settingkey !== $settingkey) {
            $config->settingkey = $request->settingkey;
        }

        $config->settingvalue = $request->settingvalue;
        $config->description = $request->description;
        $config->save();

        return redirect()->route('configuration')->with('success', 'Configuration updated successfully!');
=======
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Configuration $configuration)
    {
        //
>>>>>>> 1679f750720f54699398b3e923803854f3198352
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Configuration $configuration)
    {
<<<<<<< HEAD
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to delete configurations.');
        }

        $config = Configuration::findOrFail($settingkey);
        $configName = $config->settingkey;
        $config->delete();

        return redirect()->route('configuration')->with('success', "Configuration '{$configName}' deleted successfully!");
=======
        //
>>>>>>> 1679f750720f54699398b3e923803854f3198352
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuration $configuration)
    {
        //
    }

<<<<<<< HEAD
    public function searchConfigurations(Request $request)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to search configurations.');
        }

        $query = $request->get('q', '');

        $configurations = Configuration::where(function ($q) use ($query) {
            $q->where('settingkey', 'LIKE', "%{$query}%")
              ->orWhere('settingvalue', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->orderBy('settingkey', 'asc')
        ->get();

        return view('configurations.index', compact('configurations'));
=======
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configuration $configuration)
    {
        //
>>>>>>> 1679f750720f54699398b3e923803854f3198352
    }
}
