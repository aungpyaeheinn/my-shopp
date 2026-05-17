<div class="space-y-6">

    <!-- Slip Information -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-600">Title</label>
            <p class="text-lg font-semibold text-gray-900">{{ $viewingSlip->title }}</p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-600">Created By</label>
            <p class="text-lg text-gray-900">{{ $viewingSlip->user->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-600">Advisor</label>
            <p class="text-lg text-gray-900">{{ $viewingSlip->advisor->name }}</p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-600">Status</label>
            <p class="text-lg">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($viewingSlip->status === 'pending')
                        bg-yellow-100 text-yellow-800
                    @elseif($viewingSlip->status === 'approved')
                        bg-green-100 text-green-800
                    @else
                        bg-red-100 text-red-800
                    @endif
                ">
                    {{ ucfirst($viewingSlip->status) }}
                </span>
            </p>
        </div>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-600">Description</label>
        <p class="text-gray-900 whitespace-pre-wrap">{{ $viewingSlip->description }}</p>
    </div>

    <!-- Approve/Reject Buttons - Only for Advisor and Pending Status -->
    @if(auth()->id() === $viewingSlip->advisor_id && $viewingSlip->status === 'pending')
        <div class="flex gap-3 pt-6 border-t">
            <button 
                wire:click="approve({{ $viewingSlip->id }})"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium"
            >
                Approve
            </button>
            <button 
                wire:click="reject({{ $viewingSlip->id }})"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium"
            >
                Reject
            </button>
        </div>
    @endif

    <!-- Close Button -->
    <div class="flex pt-4">
        <button 
            wire:click="closeDetail"
            class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500"
        >
            Close
        </button>
    </div>

</div>
