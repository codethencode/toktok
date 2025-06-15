<x-layoutAdmin>
    <x-slot name="title">Liste des prix des options</x-slot>

    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">Tarifs des options</h1>

        <form method="POST" action="{{ route('admin.zone.create') }}" class="mb-8 border p-4 rounded bg-gray-50">
            @csrf
            <h2 class="text-lg font-semibold mb-2">➕ Ajouter une nouvelle zone</h2>

            <div class="flex flex-col md:flex-row md:items-center gap-2">
                <select name="categorie" required class="border p-2 w-full md:w-1/4 rounded-md border p-1 border-gray-200 text-sm">
                    <option value="">-- Choisir une catégorie --</option>
                    @foreach($allCategories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                <input type="text" name="label" placeholder="Label" required class="border p-2 rounded w-full md:w-1/4 rounded-md border p-1 border-gray-200 text-sm">
                <input type="text" name="description" placeholder="Description" class="border p-2 rounded w-full md:w-1/4  rounded-md border p-1 border-gray-200 text-sm">
                <input type="number" step="0.01" name="price" placeholder="Prix (€)" required class="border p-2 rounded w-full md:w-1/6  rounded-md border p-1 border-gray-200 text-sm">
                <button type="submit" class="custom-button bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter</button>
            </div>
        </form>

        @foreach($options as $categorie => $items)
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-2 text-blue-700 border-b border-blue-200 pb-1">Catégorie : {{ ucfirst($categorie) }}</h2>
                <form method="POST" action="{{ route('admin.options.update', ['categorie' => $categorie]) }}" class="space-y-2">
                    @csrf
                    <table class="w-full border text-sm mb-2">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">Label</th>
                                <th class="p-2 border">Description</th>
                                <th class="p-2 border text-right">Prix (€)</th>
                                <th class="p-2 border text-center">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td class="p-2 border">
                                        <input type="text" name="items[{{ $item->id }}][label]" value="{{ $item->label }}" class="w-full rounded-md border p-1 border-gray-200 text-sm">
                                    </td>
                                    <td class="p-2 border">
                                        <input type="text" name="items[{{ $item->id }}][description]" value="{{ $item->description }}" class="w-full rounded-md border p-1 border-gray-200 text-sm">
                                    </td>
                                    <td class="p-2 border text-right">
                                        <input type="number" name="items[{{ $item->id }}][price]" value="{{ $item->price }}" step="0.01" class="w-full rounded-md border p-1 border-gray-200 text-sm">
                                    </td>
                                    <td class="p-2 border text-center">
                                        <a href="{{ route('admin.zone.delete', $item->id) }}" class="text-red-600 hover:underline" onclick="return confirm('Supprimer cette zone ?');">🗑️</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        <button type="submit" class="custom-button bg-blue-600 text-white px-4 py-2 text-sm rounded hover:bg-blue-700 transition">Enregistrer cette catégorie</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
    <a href="/account" class="bg-gray-800 p-3 pl-5 pr-5 text-white rounded-md">Retour</a>
</x-layoutAdmin>