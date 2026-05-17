<div>
    <form wire:submit="store">

        <input
            type="text"
            wire:model="title"
            placeholder="Title"
        >

        <textarea
            wire:model="description"
            placeholder="Description"
        ></textarea>

        <select wire:model="advisor_id">

            <option value="">
                Select Advisor
            </option>

            @foreach($users as $user)

                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>

            @endforeach

        </select>

        <button type="submit">
            Save
        </button>

    </form>
</div>