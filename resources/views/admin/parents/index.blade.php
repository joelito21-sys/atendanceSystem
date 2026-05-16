<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manage Parents/Guardians') }}</h2>
            <a href="{{ route('admin.parents.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">+ Add Parent</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parent/Guardian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notification Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Relationship</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Children</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notifications</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($parents as $parent)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                                                <span class="text-rose-600 font-medium">{{ substr($parent->user->name ?? 'P', 0, 1) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-gray-800">{{ $parent->user->name ?? 'N/A' }}</p>
                                                <p class="text-sm text-gray-500">{{ $parent->phone_number ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $parent->notification_email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $parent->relationship }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $parent->students->count() }} student(s)</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $parent->receive_notifications ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $parent->receive_notifications ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.parents.show', $parent) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                            <a href="{{ route('admin.parents.edit', $parent) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                            <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No parents found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($parents->hasPages())<div class="px-6 py-4 border-t">{{ $parents->links() }}</div>@endif
            </div>
        </div>
    </div>
</x-app-layout>
