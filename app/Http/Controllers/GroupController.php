<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Group;

class GroupController extends Controller
{
    public function index(Request $request): View
    {
        return view('groups.list', [
            'groups' => $request->user()->groups()->get(),
        ]);
    }

    public function create(Request $request)
    {
        // Walidacja danych
        $validated = $request->validate([
            'name' => 'required|string|max:32',
            'thumb' => 'nullable|string|max:255|url',
        ]);

        // Logika zapisu do bazy danych (przykład dla modelu Group)
        Group::create([
            'name' => $validated['name'],
            'thumb' => $validated['thumb'],
            'user_id' => auth()->id()
        ]);

        // Przekierowanie lub odpowiedź JSON
        return redirect()->back()->with('success', 'Grupa została utworzona.');
    }

    public function update(Request $request)
    {
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'id' => 'required|exists:groups,id',
            'name' => 'required|string|max:255',
            'thumb' => 'nullable|string|max:255',
        ]);

        // Znajdź grupę na podstawie ID
        $group = Group::findOrFail($validated['id']);

        // Zaktualizuj pola w modelu
        $group->name = $validated['name'];
        $group->thumb = $validated['thumb'];
        $group->save(); // Zapisz zmiany w bazie danych

        // Przekierowanie lub odpowiedź JSON
        return redirect()->back()->with('success', 'Grupa została zaktualizowana pomyślnie!');
    }

    public function delete(Request $request)
    {
        // Walidacja wejścia
        $validated = $request->validate([
            'id' => 'required|exists:groups,id',
        ]);

        // Znajdź i usuń grupę
        $group = Group::findOrFail($validated['id']);
        $group->delete();

        // Przekierowanie lub odpowiedź JSON
        return redirect()->back()->with('success', 'Grupa została pomyślnie usunięta!');
    }
}
