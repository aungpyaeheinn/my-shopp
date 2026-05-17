<form wire:submit="{{ $mode === 'create' ? 'store' : 'update' }}" class="space-y-4">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input
            type="text"
            wire:model="title"
            placeholder="Enter title"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea
            wire:model="description"
            placeholder="Enter description"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>
        @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Select Advisor</label>
        <select wire:model="advisor_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Select Advisor --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('advisor_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex gap-3 pt-4">
        <button 
            type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
        >
            {{ $mode === 'create' ? 'Create' : 'Update' }}
        </button>
        <button 
            type="button"
            wire:click="{{ $mode === 'create' ? 'cancelCreate' : 'cancelEdit' }}"
            class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500"
        >
            Cancel
        </button>
    </div>

</form>
