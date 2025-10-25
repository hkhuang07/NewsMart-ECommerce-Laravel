<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class ConfigurationController extends Controller
{
    public function getList()
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to access configurations.');
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

        $request->validate([
            'settingkey' => ['required', 'string', 'max:100', 'unique:configurations'],
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

    public function postUpdate(Request $request, $settingkey)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to update configurations.');
        }

        $config = Configuration::where('settingkey', $settingkey)->firstOrFail();

        $request->validate([
            'settingkey' => ['required', 'string', 'max:100', 'unique:configurations,settingkey,' . $settingkey . ',settingkey'],
            'settingvalue' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $config->settingkey = $request->settingkey;
        $config->settingvalue = $request->settingvalue;
        $config->description = $request->description;
        $config->save();

        return redirect()->route('configurations')->with('success', 'Configuration updated successfully!');
    }

    public function getDelete($settingkey)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to delete configurations.');
        }

        $config = Configuration::where('settingkey', $settingkey)->firstOrFail();
        $key = $config->settingkey;
        $config->delete();

        return redirect()->route('configurations')->with('success', "Configuration '{$key}' deleted successfully!");
    }

    private function canManageConfigurations()
    {
        if (!auth()->check()) {
            return false;
        }

        try {
            $userRole = auth()->user()->role->name ?? 'User';
            return in_array(strtolower($userRole), ['admin', 'manager']);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getConfigurationsData()
    {
        if (!$this->canManageConfigurations()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $configs = Configuration::select(['settingkey', 'settingvalue', 'description', 'created_at', 'updated_at'])
            ->orderBy('settingkey', 'asc')
            ->get();

        return response()->json($configs);
    }

    public function searchConfigurations(Request $request)
    {
        if (!$this->canManageConfigurations()) {
            abort(403, 'You do not have permission to search configurations.');
        }

        $query = $request->get('q', '');

        $configs = Configuration::where(function ($q) use ($query) {
            $q->where('settingkey', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('settingvalue', 'LIKE', "%{$query}%");
        })
            ->orderBy('settingkey', 'asc')
            ->get();

        return view('configurations.index', compact('configs'));
    }
}
