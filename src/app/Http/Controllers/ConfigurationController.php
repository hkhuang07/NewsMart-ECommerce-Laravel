<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\PermissionController;

class ConfigurationController extends PermissionController
{

    public function getList()
    {
        if (!$this->canManageConfigurations()) { 
            abort(403, 'You do not have permission to access configuration management.');
        }

        $configurations = Configuration::orderBy('settingkey', 'asc')->get();
        return view('configurations.index', compact('configurations'));
    }

    public function getAdd()
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to add configurations.');
        }

        return view('configurations.add');
    }

    public function postAdd(Request $request): RedirectResponse
    {
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
            abort(403, 'You do not have permission to update this configuration.');
        }

        $config = Configuration::findOrFail($settingkey);

        // Validation
        $request->validate([
            'settingkey' => ['required', 'string', 'max:100', 'unique:configurations,settingkey,' . $settingkey . ',settingkey'],
            'settingvalue' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->settingkey !== $settingkey) {
            $config->settingkey = $request->settingkey;
        }

        $config->settingvalue = $request->settingvalue;
        $config->description = $request->description;
        $config->save();

        return redirect()->route('configuration')->with('success', 'Configuration updated successfully!');
    }

    public function getDelete($settingkey)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to delete configurations.');
        }

        $config = Configuration::findOrFail($settingkey);
        $configName = $config->settingkey;
        $config->delete();

        return redirect()->route('configuration')->with('success', "Configuration '{$configName}' deleted successfully!");
    }
    
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
    }
    
}