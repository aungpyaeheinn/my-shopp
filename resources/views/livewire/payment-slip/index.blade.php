<div class="space-y-6 p-6">

    <!-- Header with Create Button -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Payment Slips</h1>
        @if(!$isCreate && !$isEdit && !$isViewDetail)
            <button 
                wire:click="showCreateForm"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
            >
                Create New
            </button>
        @endif
    </div>

    <!-- Create Form -->
    @if($isCreate)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Create Payment Slip</h2>
            @include('livewire.payment-slip.form', ['mode' => 'create'])
        </div>
    @endif

    <!-- Edit Form -->
    @if($isEdit)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Payment Slip</h2>
            @include('livewire.payment-slip.form', ['mode' => 'edit'])
        </div>
    @endif

    <!-- View Detail -->
    @if($isViewDetail && $viewingSlip)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Payment Slip Details</h2>
            @include('livewire.payment-slip.detail')
        </div>
    @endif

    <!-- List of Payment Slips -->
    @if(!$isCreate && !$isEdit && !$isViewDetail)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Created By</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Advisor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($slips as $slip)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $slip->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $slip->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $slip->advisor->name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($slip->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($slip->status === 'approved')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($slip->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <button 
                                    wire:click="viewDetail({{ $slip->id }})"
                                    class="text-blue-600 hover:text-blue-900 font-medium"
                                >
                                    View
                                </button>

                                <!-- Edit: Only for owner and status is pending -->
                                @if(auth()->id() === $slip->user_id && $slip->status === 'pending')
                                    <button 
                                        wire:click="edit({{ $slip->id }})"
                                        class="text-green-600 hover:text-green-900 font-medium"
                                    >
                                        Edit
                                    </button>
                                @endif

                                <!-- Delete: Only for owner and status is pending -->
                                @if(auth()->id() === $slip->user_id && $slip->status === 'pending')
                                    <button 
                                        wire:click="delete({{ $slip->id }})"
                                        onclick="return confirm('Are you sure?')"
                                        class="text-red-600 hover:text-red-900 font-medium"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No payment slips found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>